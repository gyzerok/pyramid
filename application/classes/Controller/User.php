<?php defined('SYSPATH') or die('No direct script access.');

class Controller_User extends Controller_Smarty {

    public function action_register()
    {
        if ( ! $sponsor_id = $this->request->query('ref'))
        {
            throw new Kohana_HTTP_Exception_404;
        }

        if ($post = $this->request->post())
        {
            $db = Database::instance();
            $db->begin();

            try
            {
                $post['sponsor_id'] = $sponsor_id;

                $user = ORM::factory('User')->create_user($post, array(
                    'email',
                    'username',
                    'password',
                    'sponsor_id'
                ));
                $user->add('roles', ORM::factory('Role')->where('name', '=', 'login')->find());

                $db->commit();

                HTTP::redirect(URL::base());
            }
            catch (ORM_Validation_Exception $e)
            {
                $db->rollback();
                // @todo Тут вставить нормальный вывод ошибок валидации
                var_dump($e->errors());
            }
        }

        $this->smarty->display('register.tpl');
    }

    public function action_profile()
    {
        if ($user_id = $this->request->param('id'))
        {
            $user = ORM::factory('User', $user_id);
        }
        else
        {
            $user = Auth::instance()->get_user();
        }

        if ( ! $user OR ! $user->loaded())
        {
            throw new Kohana_HTTP_Exception_404;
        }

        $this->smarty->assign('user', $user);

        $this->smarty->display('profile.tpl');
    }

}
