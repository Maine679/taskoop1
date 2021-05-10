<?php


class Users
{
    private $db = null, $data, $session = null;
    private bool $isLoggedIn = false;

    /**
     * Users constructor.
     * @param int $user
     * Получаем идентификатор пользователя для поиска в бд.
     */
    public function __construct(int $user = null) {
        $this->db = Database::GetExample();

        $this->session = Config::Get('session.session_token_id',$GLOBALS['config']);

        if(is_null($user)) {
            if(Session::exists($this->session)) {
                $user = Session::get($this->session);
            } else return false;
        }

        if($this->find($user))
            $this->isLoggedIn = true;
    }

    /**
     * Declartion: Функция для создаения пользователя в базе данных.
     * @param array $fields
     * Принимает массив параметров поле=>значение для записи в бд
     * @return bool
     * true|false
     */
    public function create($fields= []) :bool {
        $this->db->insert('users', $fields);
        return !$this->db->error();
    }

    /**
     * Description: Функция для авторизации пользователей в системе. Проверяет существование
     * логина и правильность указанного пароля в бд.
     * @param string|null $email
     * @param string|null $password
     * @param $remember
     * @return bool
     */
    public function login(string $email = null, string $password = null, $remember = null) :bool {

        if(!is_null($email) && !is_null($password)) {
            if($this->find($email)) {
                $userData = $this->Data();
                if (password_verify($password, $userData[0]->password)) {

                    Session::put($this->session,$userData[0]->id);
                    $this->isLoggedIn = true;

                    if($remember) {
                        $hashName = Cookie::getKeyName();

                        $hash = hash('sha256',uniqid());

                        $time = time() + Config::Get('cookie.cookie_time',$GLOBALS['config']);

                        Database::GetExample()->insert('user_sessions',['user_id'=> $userData[0]->id,'hash'=>$hash,'time'=>$time]);
                        Cookie::put($hashName,$hash,$time);
                    }

                    return true;
                }
            }
        }
        else {
            $userData = $this->Data();
            if(is_numeric($userData[0]->id)) {
                Session::put($this->session,$userData[0]->id);
                $this->isLoggedIn = true;
                return true;
            }
        }
        return false;
    }

    /**
     * Description: Функция для поиска пользователя по имейл в бд.
     * @param mixed $data
     * Передаём имейл для поиска
     * @return bool
     * Возвращает данные в виде объекта.
     */
    public function find($data) :bool {
        if(is_numeric($data)) {
            $this->db->select("users","*", [["field"=>"id","criterion"=>"=","param"=>$data]]);
        } else {
            $this->db->select("users","*", [["field"=>"email","criterion"=>"=","param"=>$data]]);
        }
        $this->data = $this->db->result();

        if($this->data) {
            return true;
        }
        return false;
    }

    /**
     * Description: Возвращает данные полученные запросом find
     * @return mixed $data
     */
    public function Data() {
        return $this->data;
    }

    /**
     * Description: Проверяет залогинен пользователь или нет.
     * @return bool
     * true|false
     */
    public function IsLoggedIn() :bool {
        return $this->isLoggedIn;
    }

    /**
     * Функция для выхода пользователя из системы
     * @param void
     * @return bool
     */
    public function logout() :bool {

        if(Cookie::exists(Cookie::getKeyName())) {
            $oldHash = Cookie::get(Cookie::getKeyName());

            Database::GetExample()->delete('user_sessions',[['field'=>'hash','criterion'=>'=','param'=>$oldHash]]);
            Cookie::delete(Cookie::getKeyName());
        }

        if(Session::exists($this->session)) {
            Session::delete($this->session);
            $this->isLoggedIn = false;
        }
        return true;
    }

}