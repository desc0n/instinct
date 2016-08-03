<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin extends Controller {


	private function check_role($role_type = 1)
	{
		if($role_type == 1)
			if(!Auth::instance()->logged_in('admin'))
				HTTP::redirect('/');
		else if ($role_type == 2)
			if(!Auth::instance()->logged_in('manager'))
				HTTP::redirect('/');
	}

	public function action_index()
	{

	}

	public function action_control_panel()
	{
        /** @var $adminModel Model_Admin */
        $adminModel = Model::factory('Admin');

        /** @var $noticeModel Model_Notice */
        $noticeModel = Model::factory('Notice');

		/** @var $contentModel Model_Content */
		$contentModel = Model::factory('Content');
		
		if (Auth::instance()->logged_in() && isset($_POST['logout'])) {
			Auth::instance()->logout();
			HTTP::redirect('/');
		}
		if (!Auth::instance()->logged_in() && isset($_POST['login'])) {
			Auth::instance()->login($_POST['username'], $_POST['password'],true);
			HTTP::redirect('/admin/control_panel/');
		}
		$page = $this->request->param('id');
		$template = View::factory("admin_template");
		$admin_content = '';
		if (Auth::instance()->logged_in('admin') || $page == 'registration'){
			if (empty($page)){
				//$admin_content = Auth::instance()->logged_in('admin') ? $admin_content : '';
			} else if ($page == 'registration') {
				$admin_content = View::factory('registration')
					->set('username', Arr::get($_POST,'username',''))
					->set('email', Arr::get($_POST,'email',''))
					->set('error', '');
				if(!Auth::instance()->logged_in()) {
					if (isset($_POST['reg'])) {
						if (Arr::get($_POST,'username','')=="") {
							$error = View::factory('error');
							$error->zag = "Не указан логин!";
							$error->mess = " Укажите Ваш логин.";
							$admin_content->error = $error;
						} else if (Arr::get($_POST,'email','')=="") {
							$error = View::factory('error');
							$error->zag = "Не указана почта!";
							$error->mess = " Укажите Вашу почту.";
							$admin_content->error = $error;
						} else if (Arr::get($_POST,'password','')=="") {
							$error = View::factory('error');
							$error->zag = "Не указан пароль!";
							$error->mess = " Укажите Ваш пароль.";
							$admin_content->error = $error;
						} else if (Arr::get($_POST,'password','')!=Arr::get($_POST,'password2','')) {
							$error = View::factory('error');
							$error->zag = "Пароли не совпадают!";
							$error->mess = " Проверьте правильность подтверждения пароля.";
							$admin_content->error = $error;
						} else {
							$user = ORM::factory('User');
							$user->values(array(
								'username' => $_POST['username'],
								'email' => $_POST['email'],
								'password' => $_POST['password'],
								'password_confirm' => $_POST['password2'],
							));
							$some_error = false;
							try {
								$user->save();
								$user->add("roles",ORM::factory("Role",1));
							}
							catch (ORM_Validation_Exception $e) {
								$some_error = $e->errors('models');
							}
							if ($some_error) {
								$error = View::factory('error');
								$error->zag = "Ошибка регистрационных данных!";
								$error->mess = " Проверьте правильность ввода данных.";
								if (isset($some_error['username'])) {
									if ($some_error['username']=="models/user.username.unique") {
										$error->zag = "Такое имя уже есть в базе!";
										$error->mess = " Придумайте новое.";
									}
								}
								else if (isset($some_error['email'])) {
									if ($some_error['email']=="email address must be an email address") {
										$error->zag = "Некорректный формат почты!";
										$error->mess = " Проверьте правильность написания почты.";
									}
									if ($some_error['email']=="models/user.email.unique") {
										$error->zag = "Такая почта есть в базе!";
										$error->mess = " Укажите другую почту.";
									}
								}
								$admin_content->error = $error;
							}
						}
					}
				}
			} else if ($page == 'add_notice') {
				$admin_content = View::factory('add_notice')
                    ->set('get', $_GET);

				if (isset($_POST['addnotice'])) {
                    $id = $adminModel->addNotice($_POST);
                    HTTP::redirect('/admin/control_panel/redact_notice?id=' . $id);
				}

                if (isset($_POST['removeproduct'])) {
                    $noticeModel->deleteNotice(['id' => $_POST['removeproduct']]);
                    HTTP::redirect('/admin/control_panel/add_notice');
                }
			} else if ($page == 'redact_notice') {
				$notice_id = Arr::get($_GET, 'id', 0);
				$removeimg = isset($_POST['removeimg']) ? $_POST['removeimg'] : 0;
				$filename = Arr::get($_FILES, 'imgname', []);
				$files = Arr::get($_FILES, 'filename', []);

				if ($notice_id != '' && !empty($filename)) {
					$adminModel->loadNoticeImg($_FILES, $notice_id);
					HTTP::redirect('/admin/control_panel/redact_notice?id='.$notice_id);
				}

				if ($notice_id != '' && !empty($files)) {
                    $noticeModel->loadNoticeFile($_FILES, $notice_id);
					HTTP::redirect('/admin/control_panel/redact_notice?id='.$notice_id);
				}

				if ($removeimg != 0) {
					$noticeModel->removeNoticeImg($_POST);
					HTTP::redirect('/admin/control_panel/redact_notice?id='.$notice_id);
				}

				$removeFile = Arr::get($_POST, 'removefile');
				
				if (!empty($removeFile)) {
					$noticeModel->removeNoticeFile($_POST);
					HTTP::redirect('/admin/control_panel/redact_notice?id='.$notice_id);
				}

                if (isset($_POST['redactnotice'])) {
                    $noticeModel->setNotice($_POST);
                    HTTP::redirect('/admin/control_panel/redact_notice?id=' . Arr::get($_GET, 'id', 0));
                }

                if (isset($_POST['newNoticeParam'])) {
                    $noticeModel->setNoticeParams($_POST);
                    HTTP::redirect('/admin/control_panel/redact_notice?id=' . Arr::get($_GET, 'id', 0));
                }

                if (isset($_POST['removeProductParam'])) {
                    $noticeModel->removeNoticeParams($_POST);
                    HTTP::redirect('/admin/control_panel/redact_notice?id=' . Arr::get($_GET, 'id', 0));
                }

				$notice = $noticeModel->getNotice($_GET);
                $categoryNotices = (!empty($notice) ? $noticeModel->getNotice(['category_id' => $notice[0]['category']]) : []);
                $sortData = [];

                foreach ($categoryNotices as $noticesData) {
                    $sortData[$noticesData['sort']] = $noticesData['sort'];
                }

				$admin_content = View::factory('admin_redact_notice')
					->set('notice_info', (!empty($notice) ? $notice[0] : []))
					->set('sortData', $sortData)
					->set('noticeParams', $noticeModel->getNoticeParams($_GET))
					->set('get', $_GET)
					->set('notice_id', $notice_id);
			} else if ($page == 'reviews_moderation') {
                if (isset($_POST['unshowreview'])) {
                    $adminModel->setReview([
                        'id' => $_POST['unshowreview'],
                        'status' => 0
                    ]);
                    HTTP::redirect('/admin/control_panel/reviews_moderation');
                }

                if (isset($_POST['showreview'])) {
                    $adminModel->setReview([
                        'id' => $_POST['showreview'],
                        'status' => 1
                    ]);
                    HTTP::redirect('/admin/control_panel/reviews_moderation');
                }

                $admin_content = View::factory('reviews_moderation')
                    ->set('showedReviewsData', $adminModel->findReviews(['status' => 1]))
                    ->set('unshowedReviewsData', $adminModel->findReviews(['status' => 0]))
                    ->set('get', $_GET);
			} else if ($page == 'redact_main_page') {
                if (isset($_POST['addhit'])) {
                    $adminModel->addHit($_POST);
                    HTTP::redirect('/admin/control_panel/redact_main_page');
                }

                if (isset($_POST['removehit'])) {
                    $adminModel->removeHit($_POST);
                    HTTP::redirect('/admin/control_panel/redact_main_page');
                }

                if (isset($_POST['redactpage'])) {
                    $adminModel->setPage($_POST);
                    HTTP::redirect('/admin/control_panel/redact_main_page');
                }

                $admin_content = View::factory('admin_redact_main_page')
                    ->set('pageData', $contentModel->getPage(['id' => 3]))
                    ->set('get', $_GET);
			} else if ($page == 'redact_catalogs') {
                $filename=Arr::get($_FILES, 'filename', '');

                if (!empty($filename)) {
                    $adminModel->loadCatalogs($_FILES);
                    HTTP::redirect('/admin/control_panel/redact_catalogs');
                }

                if (isset($_POST['removefile'])) {
                    $adminModel->removeCatalogs($_POST);
                    HTTP::redirect('/admin/control_panel/redact_catalogs');
                }

                $admin_content = View::factory('admin_redact_catalogs')
                    ->set('catalogsData', $adminModel->getCatalogsData())
                    ->set('get', $_GET);
			} else if ($page == 'redact_page') {
				if (isset($_POST['redactpage'])) {
					$adminModel->setPage($_POST);
					HTTP::redirect($this->request->referrer());
				}

				$admin_content = View::factory('admin_redact_page')
					->set('pages', $contentModel->getPages())
					->set('pageData', $contentModel->getPage($_GET))
					->set('get', $_GET)
				;
			} else if ($page == 'add_category') {
				if (isset($_POST['addgroup'])) {
                    $adminModel->addCategory($_POST);
                    HTTP::redirect('/admin/control_panel/add_category');
                }

                if (isset($_POST['removegroup'])) {
                    $adminModel->removeCategory($_POST);
                    HTTP::redirect('/admin/control_panel/add_category');
                }

				$admin_content = View::factory('admin_add_category')
					->set('get', $_GET);
			}
		}
		$this->response->body($template->set('admin_content', $admin_content));
	}
}