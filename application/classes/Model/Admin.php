<?php

/**
 * Class Model_Admin
 */
class Model_Admin extends Kohana_Model
{

	private $user_id;

	public function __construct()
	{
		if (Auth::instance()->logged_in()) {
			$this->user_id = Auth::instance()->get_user()->id;
		} else {
			$this->user_id = 0;
		}
		DB::query(Database::UPDATE, "SET time_zone = '+10:00'")->execute();
	}

	public function getCategory($cid = null, $id = null)
	{
        $data = [];

        if ($cid !== null && $id === null) {
            return DB::query(Database::SELECT, "select * from `category` where `parent_id` = :id")
                ->param(':id', $cid)
                ->execute()
                ->as_array();
        } elseif ($id !== null) {
            return DB::query(Database::SELECT, "select * from `category` where `id` = :id")
                ->param(':id', $id)
                ->execute()
                ->as_array();
        } else {
            return DB::query(Database::SELECT, "select * from `category` where `parent_id` is null")
                ->execute()
                ->as_array();
        }
	}

	public function addCategory($params = [])
	{
		$res = DB::query(Database::INSERT, "insert into `category` (`name`, `parent_id`) values (:name, :parent_id)")
			->param(':name', Arr::get($params, 'group_name', ''))
			->param(':parent_id', Arr::get($params, 'parent_id', null))
			->execute();

		return $res[0];
	}

	public function removeCategory($params = [])
	{
		DB::query(Database::DELETE, "delete from `category` where `id` = :id")
			->param(':id', Arr::get($params, 'removegroup', null))
			->execute();
	}

	public function addNotice($params = [])
	{
		$res = DB::query(Database::INSERT, "insert into `notice` (`name`, `category`) values (:name, :category)")
			->param(':name', Arr::get($params, 'name', ''))
			->param(':category', Arr::get($params, 'category', null))
			->execute();

		$noticeId = $res[0];

        $sql = "update `notice` set `sort` = :id where `id` = :id";
        DB::query(Database::UPDATE,$sql)
            ->param(':id', $noticeId)
            ->execute();

        return $noticeId;
	}


	public function loadNoticeImg($filesGlobal, $notice_id)
	{
		$filesData = [];

		foreach ($filesGlobal['imgname']['name'] as $key => $data) {
			$filesData[$key]['name'] = $filesGlobal['imgname']['name'][$key];
			$filesData[$key]['type'] = $filesGlobal['imgname']['type'][$key];
			$filesData[$key]['tmp_name'] = $filesGlobal['imgname']['tmp_name'][$key];
			$filesData[$key]['error'] = $filesGlobal['imgname']['error'][$key];
			$filesData[$key]['size'] = $filesGlobal['imgname']['size'][$key];
		}

		foreach ($filesData as $files) {
			$sql = "insert into `notice_img` (`notice_id`) values (:id)";
			$res = DB::query(Database::INSERT,$sql)
                ->param(':id', $notice_id)
                ->execute();

			$new_id = $res[0];
			$imageName = preg_replace("/[^0-9a-z.]+/i", "0", Arr::get($files,'name',''));
			$file_name = 'public/img/original/'.$new_id.'_'.$imageName;
			if (copy($files['tmp_name'], $file_name))	{
				$image=Image::factory($file_name);
				$image->resize(500, NULL);
				$image->save($file_name,100);
				$thumb_file_name = 'public/img/thumb/'.$new_id.'_'.$imageName;

				if (copy($files['tmp_name'], $thumb_file_name))	{
					$thumb_image=Image::factory($thumb_file_name);
					$thumb_image->resize(300, NULL);
					$thumb_image->save($thumb_file_name,100);

					$sql = "update `notice_img` set `src` = :src,`status_id` = 1 where `id` = :id";
					DB::query(Database::UPDATE,$sql)
                        ->param(':id', $new_id)
                        ->param(':src', $new_id.'_'.$imageName)
                        ->execute();
				}
			}
		}
	}

	public function addNoticeSale($params = [])
	{
		DB::query(Database::INSERT, "insert into `notice_sale` (`name`, `category`) values (:name, :category)")
			->param(':name', Arr::get($params, 'name', ''))
			->param(':category', Arr::get($params, 'category', null))
			->execute();
		$res = DB::query(Database::SELECT, "select last_insert_id() as `id` from `notice_sale`")
			->execute()
			->as_array();
		return $res[0]['id'];
	}

	public function loadNoticeSaleImg($filesGlobal, $notice_id)
	{
		$filesData = [];
		foreach ($filesGlobal['imgname']['name'] as $key => $data) {
			$filesData[$key]['name'] = $filesGlobal['imgname']['name'][$key];
			$filesData[$key]['type'] = $filesGlobal['imgname']['type'][$key];
			$filesData[$key]['tmp_name'] = $filesGlobal['imgname']['tmp_name'][$key];
			$filesData[$key]['error'] = $filesGlobal['imgname']['error'][$key];
			$filesData[$key]['size'] = $filesGlobal['imgname']['size'][$key];
		}
		foreach ($filesData as $files) {
			$sql = "insert into `notice_sale_img` (`notice_id`) values (:id)";
			$query = DB::query(Database::INSERT,$sql);
			$query->param(':id', $notice_id);
			$query->execute();
			$sql = "select last_insert_id() as `new_id` from `notice_sale_img`";
			$query = DB::query(Database::SELECT,$sql);
			$res = $query->execute()->as_array();
			$new_id = $res[0]['new_id'];
			$imageName = preg_replace("/[^0-9a-z.]+/i", "0", Arr::get($files,'name',''));
			$file_name = 'public/img/sale/original/'.$new_id.'_'.$imageName;
			if (copy($files['tmp_name'], $file_name))	{
				//$this->setWaterMark('original/'.$new_id.'_'.Arr::get($files,'name',''));
				//$new_image = $this->picture($files['tmp_name']);
				//$this->imageresizewidth(120);
				//$this->imagesave('jpeg', 'public/img/thumb/'.$new_id.'_'.Arr::get($files,'name',''));
				$image=Image::factory($file_name);
				$image->resize(800, NULL);
				$watermark=Image::factory('public/i/watermark.png');
				$watermark->rotate(-45);
				$image->watermark($watermark, $offset_x = null, $offset_y = null, $opacity = 100);
				$image->save($file_name,100);
				$thumb_file_name = 'public/img/sale/thumb/'.$new_id.'_'.$imageName;
				if (copy($files['tmp_name'], $thumb_file_name))	{
					$thumb_image=Image::factory($thumb_file_name);
					$thumb_image->resize(300, NULL);
					$thumb_watermark=Image::factory('public/i/watermark.png');
					$thumb_watermark->rotate(-45);
					$thumb_watermark->resize(100, NULL);
					$thumb_image->watermark($thumb_watermark, $offset_x = null, $offset_y = null, $opacity = 100);
					$thumb_image->save($thumb_file_name,100);
					$sql = "update `notice_sale_img` set `src` = :src,`status_id` = 1 where `id` = :id";
					$query=DB::query(Database::UPDATE,$sql);
					$query->param(':id', $new_id);
					$query->param(':src', $new_id.'_'.$imageName);
					$query->execute();
				}
			}
		}
	}

	//Готовое решение с картинками
	public function picture($image_file)
	{
		$this->image_file=$image_file;
		$image_info = getimagesize($this->image_file);
		$this->image_width = $image_info[0];
		$this->image_height = $image_info[1];
		switch($image_info[2]) {
			case 1: $this->image_type = 'gif'; break;//1: IMAGETYPE_GIF
			case 2: $this->image_type = 'jpeg'; break;//2: IMAGETYPE_JPEG
			case 3: $this->image_type = 'png'; break;//3: IMAGETYPE_PNG
			case 4: $this->image_type = 'swf'; break;//4: IMAGETYPE_SWF
			case 5: $this->image_type = 'psd'; break;//5: IMAGETYPE_PSD
			case 6: $this->image_type = 'bmp'; break;//6: IMAGETYPE_BMP
			case 7: $this->image_type = 'tiffi'; break;//7: IMAGETYPE_TIFF_II (порядок байт intel)
			case 8: $this->image_type = 'tiffm'; break;//8: IMAGETYPE_TIFF_MM (порядок байт motorola)
			case 9: $this->image_type = 'jpc'; break;//9: IMAGETYPE_JPC
			case 10: $this->image_type = 'jp2'; break;//10: IMAGETYPE_JP2
			case 11: $this->image_type = 'jpx'; break;//11: IMAGETYPE_JPX
			case 12: $this->image_type = 'jb2'; break;//12: IMAGETYPE_JB2
			case 13: $this->image_type = 'swc'; break;//13: IMAGETYPE_SWC
			case 14: $this->image_type = 'iff'; break;//14: IMAGETYPE_IFF
			case 15: $this->image_type = 'wbmp'; break;//15: IMAGETYPE_WBMP
			case 16: $this->image_type = 'xbm'; break;//16: IMAGETYPE_XBM
			case 17: $this->image_type = 'ico'; break;//17: IMAGETYPE_ICO
			default: $this->image_type = ''; break;
		}
		$this->fotoimage();
	}

	private function fotoimage()
	{
		switch($this->image_type) {
			case 'gif': $this->image = imagecreatefromgif($this->image_file); break;
			case 'jpeg': $this->image = imagecreatefromjpeg($this->image_file); break;
			case 'png': $this->image = imagecreatefrompng($this->image_file); break;
		}
	}

	public function autoimageresize($new_w, $new_h)
	{
		$difference_w = 0;
		$difference_h = 0;
		if($this->image_width < $new_w && $this->image_height < $new_h) {
			$this->imageresize($this->image_width, $this->image_height);
		}
		else {
			if($this->image_width > $new_w) {
				$difference_w = $this->image_width - $new_w;
			}
			if($this->image_height > $new_h) {
				$difference_h = $this->image_height - $new_h;
			}
			if($difference_w > $difference_h) {
				$this->imageresizewidth($new_w);
			}
			elseif($difference_w < $difference_h) {
				$this->imageresizeheight($new_h);
			}
			else {
				$this->imageresize($new_w, $new_h);
			}
		}
	}

	public function percentimagereduce($percent)
	{
		$new_w = $this->image_width * $percent / 100;
		$new_h = $this->image_height * $percent / 100;
		$this->imageresize($new_w, $new_h);
	}

	public function imageresizewidth($new_w)
	{
		$new_h = $this->image_height * ($new_w / $this->image_width);
		$this->imageresize($new_w, $new_h);
	}

	public function imageresizeheight($new_h)
	{
		$new_w = $this->image_width * ($new_h / $this->image_height);
		$this->imageresize($new_w, $new_h);
	}

	public function imageresize($new_w, $new_h)
	{
		$new_image = imagecreatetruecolor($new_w, $new_h);
		imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $new_w, $new_h, $this->image_width, $this->image_height);
		$this->image_width = $new_w;
		$this->image_height = $new_h;
		$this->image = $new_image;
	}

	public function imagesave($image_type='jpeg', $image_file=NULL, $image_compress=100, $image_permiss='')
	{
		if($image_file==NULL) {
			switch($this->image_type) {
				case 'gif': header("Content-type: image/gif"); break;
				case 'jpeg': header("Content-type: image/jpeg"); break;
				case 'png': header("Content-type: image/png"); break;
			}
		}
		switch($this->image_type) {
			case 'gif': imagegif($this->image, $image_file); break;
			case 'jpeg': imagejpeg($this->image, $image_file, $image_compress); break;
			case 'png': imagepng($this->image, $image_file); break;
		}
		if($image_permiss != '') {
			chmod($image_file, $image_permiss);
		}
	}

	public function imageout()
	{
		imagedestroy($this->image);
	}

	public function setWaterMark($file_name)
	{
		// Сначала создаем наше изображение штампа вручную с помощью GD
		$stamp = imagecreatetruecolor(100, 70);
		$im = imagecreatefromjpeg('public/img/' . $file_name);
		imagestring($stamp, 5, 20, 20, 'wallet.ru', 0x0000FF);

		// Установка полей для штампа и получение высоты/ширины штампа
		$marge_right = 10;
		$marge_bottom = 10;
		$sx = imagesx($stamp);
		$sy = imagesy($stamp);

		// Слияние штампа с фотографией. Прозрачность 50%
		imagecopymerge($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp), 50);

		// Сохранение фотографии в файл и освобождение памяти
		imagepng($im, 'public/img/mark/' . $file_name);
		imagedestroy($im);
	}

	public function getPages()
	{
		return DB::query(Database::SELECT, "
            select `p`.*
            from `pages` `p`
            inner join `menu` `m`
                on `m`.`page_id` = `p`.`id`
            where `m`.`status_id` = 1
        ")
			->execute()
			->as_array();
	}

	public function getPage($params = [])
	{
		$id = Arr::get($params, 'id', 0);
		$res = DB::query(Database::SELECT, "
            select `p`.*
            from `pages` `p`
            where `p`.`id` = :id
        ")
			->param(':id', $id)
			->execute()
			->as_array();

		return !empty($res) ? $res[0] : [];
	}

	public function setPage($params = [])
	{
		$id = Arr::get($params, 'redactpage', 0);
		DB::query(Database::UPDATE, "update `pages` set `content` = :text where `id` = :id")
			->param(':id', $id)
			->param(':title', Arr::get($params, 'title'))
			->param(':text', Arr::get($params, 'text'))
			->execute();
	}

    public function addMenu($params = [])
    {
        $res = DB::query(Database::INSERT, "insert into `pages` (`title`) values (:name)")
            ->param(':name', Arr::get($params, 'menu_name', ''))
            ->execute();

        $pegeId = $res[0];

        $res = DB::query(Database::INSERT, "insert into `menu` (`parent_id`, `page_id`) values (:parent_id, :page_id)")
            ->param(':parent_id', Arr::get($params, 'parent_id', null))
            ->param(':page_id', $pegeId)
            ->execute();

        return $pegeId;
    }

    public function removeMenu($params = [])
    {
        DB::query(Database::DELETE, "delete from `menu` where `id` = :id")
            ->param(':id', Arr::get($params, 'removemenu', null))
            ->execute();
    }

    public function getHomePageData()
    {
        $data = [
            'big_img' => [],
            'small_img' => [],
        ];

        $res = DB::query(Database::SELECT, "select `p`.* from `home_page` `p`")
            ->execute()
            ->as_array();

        foreach ($res as $row) {
            $data[$row['name']] = $row['value'];
        }

        $res = DB::query(Database::SELECT, "select `p`.* from `home_page_img` `p`")
            ->execute()
            ->as_array();

        foreach ($res as $row) {
            if ($row['type'] == 'big') {
                $data['big_img'][$row['id']] = $row['name'];
            } elseif ($row['type'] == 'small') {
                $data['small_img'][$row['id']] = $row['name'];
            }
        }

        return $data;
    }

    public function getHomePage()
    {
        return DB::query(Database::SELECT, "select `p`.* from `home_page` `p`")
            ->execute()
            ->as_array();
    }

    public function setHomePageData($params = [])
    {
        foreach ($params as $name => $value) {
            DB::query(Database::UPDATE, 'update `home_page` set `value` = :value where `name` = :name')
                ->param(':name', $name)
                ->param(':value', $value)
                ->execute();
        }
    }

    public function setHomePageTitle($params = [])
    {
        foreach ($params as $name => $value) {
            DB::query(Database::UPDATE, 'update `home_page` set `title` = :value where `name` = :name')
                ->param(':name', $name)
                ->param(':value', $value)
                ->execute();
        }
    }

    public function loadHomePageImg($filesGlobal, $type)
    {
        $filesData = [];

        foreach ($filesGlobal['imgname']['name'] as $key => $data) {
            $filesData[$key]['name'] = $filesGlobal['imgname']['name'][$key];
            $filesData[$key]['type'] = $filesGlobal['imgname']['type'][$key];
            $filesData[$key]['tmp_name'] = $filesGlobal['imgname']['tmp_name'][$key];
            $filesData[$key]['error'] = $filesGlobal['imgname']['error'][$key];
            $filesData[$key]['size'] = $filesGlobal['imgname']['size'][$key];
        }

        foreach ($filesData as $files) {
            $sql = "insert into `home_page_img` (`type`) values (:type)";
            $res = DB::query(Database::INSERT,$sql)
                ->param(':type', $type)
                ->execute();

            $new_id = $res[0];
            $imageType = substr($files['name'], (strrpos($files['name'], '.') + 1));
            $file_name = 'public/i/home/' . $type . '/' . $new_id.'.'.$imageType;
            if (copy($files['tmp_name'], $file_name))	{
                $image=Image::factory($file_name);
                $image->resize($type == 'big' ? 1155 : 330, NULL);
                $image->save($file_name,100);

                $sql = "update `home_page_img` set `name` = :name where `id` = :id";
                DB::query(Database::UPDATE,$sql)
                    ->param(':id', $new_id)
                    ->param(':name', $new_id.'.'.$imageType)
                    ->execute();
            }
        }
    }

    public function removeHomePageImg($params = [])
    {
        $sql = "delete from `home_page_img` where `id` = :id";
        DB::query(Database::UPDATE,$sql)
            ->param(':id', Arr::get($params,'removeimg'))
            ->execute();
    }

    public function getMainPageData()
    {
        $data = [];

        $res = DB::query(Database::SELECT, "select `p`.* from `main_page_img` `p`")
            ->execute()
            ->as_array();

        foreach ($res as $row) {
            $data[$row['id']] = $row['name'];
        }

        return $data;
    }

    public function loadMainPageImg($filesGlobal)
    {
        $filesData = [];

        foreach ($filesGlobal['imgname']['name'] as $key => $data) {
            $filesData[$key]['name'] = $filesGlobal['imgname']['name'][$key];
            $filesData[$key]['type'] = $filesGlobal['imgname']['type'][$key];
            $filesData[$key]['tmp_name'] = $filesGlobal['imgname']['tmp_name'][$key];
            $filesData[$key]['error'] = $filesGlobal['imgname']['error'][$key];
            $filesData[$key]['size'] = $filesGlobal['imgname']['size'][$key];
        }

        foreach ($filesData as $files) {
            $sql = "insert into `main_page_img` (`name`) values ('')";
            $res = DB::query(Database::INSERT,$sql)
                ->execute();

            $new_id = $res[0];
            $imageType = substr($files['name'], (strrpos($files['name'], '.') + 1));
            $file_name = 'public/i/slider/' . $new_id.'.'.$imageType;
            if (copy($files['tmp_name'], $file_name))	{
                $image=Image::factory($file_name);
                $image->resize(1155, NULL);
                $image->save($file_name,100);

                $sql = "update `main_page_img` set `name` = :name where `id` = :id";
                DB::query(Database::UPDATE,$sql)
                    ->param(':id', $new_id)
                    ->param(':name', $new_id.'.'.$imageType)
                    ->execute();
            }
        }
    }

    public function removeMainPageImg($params = [])
    {
        $sql = "delete from `main_page_img` where `id` = :id";
        DB::query(Database::UPDATE,$sql)
            ->param(':id', Arr::get($params,'removeimg'))
            ->execute();
    }

    public function getCatalogsData()
    {
        $data = [];

        $res = DB::query(Database::SELECT, "select * from `catalogs`")
            ->execute()
            ->as_array();

        foreach ($res as $row) {
            $data[$row['id']] = $row['name'];
        }

        return $data;
    }

    public function loadCatalogs($filesGlobal)
    {
        $filesData = [];

        foreach ($filesGlobal['filename']['name'] as $key => $data) {
            $filesData[$key]['name'] = $filesGlobal['filename']['name'][$key];
            $filesData[$key]['type'] = $filesGlobal['filename']['type'][$key];
            $filesData[$key]['tmp_name'] = $filesGlobal['filename']['tmp_name'][$key];
            $filesData[$key]['error'] = $filesGlobal['filename']['error'][$key];
            $filesData[$key]['size'] = $filesGlobal['filename']['size'][$key];
        }

        foreach ($filesData as $files) {
            $sql = "insert into `catalogs` (`name`) values ('')";
            $res = DB::query(Database::INSERT,$sql)
                ->execute();

            $new_id = $res[0];
            $imageType = substr($files['name'], (strrpos($files['name'], '.') + 1));
            $file_name = 'public/catalogs/' . Arr::get($files,'name','');
            if (copy($files['tmp_name'], $file_name))	{
                $sql = "update `catalogs` set `name` = :name where `id` = :id";
                DB::query(Database::UPDATE,$sql)
                    ->param(':id', $new_id)
                    ->param(':name', Arr::get($files,'name',''))
                    ->execute();
            }
        }
    }

    public function removeCatalogs($params = [])
    {
        $sql = "delete from `catalogs` where `id` = :id";
        DB::query(Database::UPDATE,$sql)
            ->param(':id', Arr::get($params,'removefile'))
            ->execute();
    }

    public function setGuestId()
    {
        $res = DB::query(Database::INSERT, 'insert into `guests` (`date`) values (now())')
            ->execute();

        $guestId = Arr::get($res, 0);

        Cookie::set('guest_id', $guestId);

        return $guestId;
    }

    public function addToCart($params = [])
    {
        $params['guest_id'] = Cookie::get('guest_id');
        $cartData = $this->getCart($params);

        if (empty($cartData)) {
            DB::query(Database::INSERT, 'insert into `cart` (`guest_id`, `notice_id`, `date`) values (:guest_id, :item, now())')
                ->param(':guest_id', Arr::get($params, 'guest_id'))
                ->param(':item', Arr::get($params, 'item'))
                ->execute();
        } else {
            DB::query(Database::UPDATE, 'update `cart` set `num` = (`num` + 1) where `notice_id` = :item and `guest_id` = :guest_id and `show` = 1')
                ->param(':guest_id', Arr::get($params, 'guest_id'))
                ->param(':item', Arr::get($params, 'item'))
                ->execute();
        }
    }

    public function plusCartNum($params = [])
    {
        DB::query(Database::UPDATE, 'update `cart` set `num` = (`num` + 1) where `id` = :id')
            ->param(':id', Arr::get($params, 'id'))
            ->execute();

        return Arr::get(Arr::get($this->getCart($params), 0, []), 'num', 0);
    }

    public function minusCartNum($params = [])
    {
        DB::query(Database::UPDATE, 'update `cart` set `num` = if(`num` > 1, (`num` - 1), 1) where `id` = :id')
            ->param(':id', Arr::get($params, 'id'))
            ->execute();

        return Arr::get(Arr::get($this->getCart($params), 0, []), 'num', 0);
    }

    public function removeFromCart($params = [])
    {
        DB::query(Database::UPDATE, 'update `cart` set `show` = 0 where `id` = :id')
            ->param(':id', Arr::get($params, 'id'))
            ->execute();

        return 'ok';
    }

    public function removeAllCart()
    {
        DB::query(Database::UPDATE, 'update `cart` set `show` = 0 where `guest_id` = :guest_id')
            ->param(':guest_id', Cookie::get('guest_id'))
            ->execute();

        return 'ok';
    }

    public function getCart($params = [])
    {
		$guestId = Arr::get($params, 'guest_id');
		$item = Arr::get($params, 'item');
		$id = Arr::get($params, 'id');
		
        $guestSql = !empty($guestId) ? ' and `c`.`guest_id` = :guest_id' : '';
        $noticeSql = !empty($item) ? ' and `c`.`notice_id` = :item' : '';
        $idSql = !empty($id) ? ' and `c`.`id` = :id' : '';

        return DB::query(Database::SELECT, "
            select `c`.*, `n`.*, `c`.`id`, `n`.`id` as `notice_id`
            from `cart` `c`
            inner join `notice` `n`
                on `n`.`id` = `c`.`notice_id`
            where `c`.`show` = :show
            $guestSql
            $noticeSql
            $idSql
        ")
            ->param(':guest_id', $guestId)
            ->param(':item', $item)
            ->param(':show', Arr::get($params, 'show', 1))
            ->param(':id', $id)
            ->execute()
            ->as_array();
    }

    public function getCartNum()
    {
        $res = DB::query(Database::SELECT, "
            select sum(`c`.`num`) as `num`
            from `cart` `c`
            inner join `notice` `n`
                on `n`.`id` = `c`.`notice_id`
            where `c`.`show` = 1
            and `c`.`guest_id` = :guest_id
        ")
            ->param(':guest_id', Cookie::get('guest_id'))
            ->execute()
            ->as_array();

        return Arr::get(Arr::get($res, 0, []), 'num', 0);
    }

    public function addOrder($params = [])
    {
        $params['order_id'] = $this->setOrder();
        $params['guest_id'] = Cookie::get('guest_id');
        $params['cart_data'] = $this->getCart($params);

        $this->setOrderClient($params);
        $this->setOrderPart($params);
        $this->setOrderStatus($params);

        $view = View::factory('add_order_mail')
            ->set('cartData', $params['cart_data'])
            ->set('params', $params);

        $this->sendMail('walletvl@yandex.ru', 'Заказ с сайта', $view, true);

        return $params['order_id'];
    }

    public function setOrder()
    {
        $res = DB::query(Database::INSERT, 'INSERT INTO `orders__orders` (`date`) VALUES (now())')
            ->execute();

        return Arr::get($res, 0);
    }

    public function setOrderClient($params = [])
    {
        $phone = Arr::get($params, 'phone');
        $phone = str_replace('+7', '', $phone);
        $phone = substr($phone, 0, 1) == 8 ? substr($phone, 1) : $phone;

        DB::query(Database::INSERT, '
            INSERT INTO `orders__clients`
            (`order_id`, `name`, `address`, `email`, `phone`, `comments`)
            VALUES (:order_id, :name, :address, :email, :phone, :comments)
            ON DUPLICATE KEY UPDATE `name` = :name,
            `address` = :address,
            `email` = :email,
            `phone` = :phone,
            `comments` = :comments
        ')
            ->param(':order_id', Arr::get($params, 'order_id'))
            ->param(':name', Arr::get($params, 'name'))
            ->param(':address', Arr::get($params, 'address'))
            ->param(':email', Arr::get($params, 'email'))
            ->param(':comments', Arr::get($params, 'comments'))
            ->param(':phone', $phone)
            ->execute();
    }

    public function setOrderPart($params = [])
    {
        foreach (Arr::get($params, 'cart_data', []) as $data) {
            DB::query(Database::INSERT, 'INSERT INTO `orders__parts` (`order_id`, `part`, `num`) VALUES (:order_id, :part, :num)')
                ->param(':order_id', Arr::get($params, 'order_id'))
                ->param(':part', $data['name'])
                ->param(':num', $data['num'])
                ->execute();
        }
    }

    public function setOrderStatus($params = [])
    {
        DB::query(Database::INSERT, '
            INSERT INTO `orders__statuses`
            (`order_id`, `status`)
            VALUES (:order_id, :status)
            ON DUPLICATE KEY UPDATE `status` = :status
        ')
            ->param(':order_id', Arr::get($params, 'order_id'))
            ->param(':status', Arr::get($params, 'status', 1))
            ->execute();
    }

    public function findOrderStatus($params = [])
    {
        $res = DB::query(Database::SELECT, 'SELECT * FROM `orders__statuses` WHERE `order_id` = :order_id LIMIT 0,1')
            ->param(':order_id', Arr::get($params, 'order_id'))
            ->execute()
            ->as_array();

        return Arr::get($res, 0, []);
    }

    public function sendMail($email, $subject, $view = null, $order = false)
    {
        $to = $email;
        $message = $view !== null ? $view : '';
        $bound = "0";
        $header = "";
        $header .= "Subject: $subject\n";
        $header .= "Mime-Version: 1.0\n";
        $header .= "Content-Type: multipart/mixed; boundary=\"$bound\"";
        $body = "\n\n--$bound\n";
        $body .= "Content-type: text/html; charset=\"utf-8\"\n";
        $body .= "Content-Transfer-Encoding: quoted-printable\n\n";
        $body .= "$message";

        if (mail($to, $subject, $body, $header)) {
            if ($order) {
                $this->removeAllCart();
            }
        }
    }

    public function findReviews($params = [])
    {
        $idSql = Arr::get($params, 'id') != null ? ' and `id` = :id' : '';

        return DB::query(Database::SELECT, "SELECT * FROM `reviews` WHERE `status` = :status $idSql")
            ->param(':id', Arr::get($params, 'id'))
            ->param(':status', Arr::get($params, 'status', 1))
            ->execute()
            ->as_array();
    }

    public function addReview($params = [])
    {
        DB::query(Database::INSERT, "insert into `reviews`
            (`author`, `city`, `content`, `date`)
            values (:author, :city, :review, now())
        ")
            ->param(':author', Arr::get($params, 'author'))
            ->param(':city', Arr::get($params, 'city'))
            ->param(':review', Arr::get($params, 'review'))
            ->execute();

        $this->sendMail('walletvl@yandex.ru', 'Новый отзыв на сайте');

        return 'ok';
    }

    public function setReview($params = [])
    {
        DB::query(Database::UPDATE, "update `reviews` set `status` = :status where `id` = :id")
            ->param(':status', Arr::get($params, 'status'))
            ->param(':id', Arr::get($params, 'id'))
            ->execute();
    }

    public function removeHit($params = [])
    {
        DB::query(Database::DELETE, "delete from `hits` where `notice_id` = :id")
            ->param(':id', Arr::get($params, 'removehit'))
            ->execute();
    }

    public function addHit($params = [])
    {
        DB::query(Database::INSERT, "insert into `hits` (`notice_id`) values (:notice_id) on duplicate key update `notice_id` = :notice_id")
            ->param(':notice_id', Arr::get($params, 'addhit'))
            ->execute();
    }
}
?>