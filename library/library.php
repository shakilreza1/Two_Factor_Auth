<?php


class DemoLib
{

    protected $db;

    function __construct($db)
    {
        $this->db = $db;
    }

    function __destruct()
    {
        $this->db = null;
    }

    /*
     * Register New User
     *
     * @param $name, $email, $username, $password, $auth_code
     * @return ID
     * */
    public function Register($name, $email, $username, $password, $google_secret_code)
    {
        $query = $this->db->prepare("INSERT INTO users(name, email, username, password, google_secret_code) VALUES (:name,:email,:username,:password,:google_secret_code)");
        $query->bindParam("name", $name);
        $query->bindParam("email", $email);
        $query->bindParam("username", $username);
        // $enc_password = password_hash($password, PASSWORD_DEFAULT, ['cost' => 11]);
        $hash = password_hash($password, PASSWORD_DEFAULT); //PASSWORD_BCRYPT uses the CRYPT_BLOWFISH algorithm and will return a 60 character string. //cost - The algorithmic cost to be used. Default value is 10.

        $query->bindParam("password", $hash);
        $query->bindParam("google_secret_code", $google_secret_code);
        $query->execute();
        return $this->db->lastInsertId();
    }

    /*
     * Check Username
     *
     * @param $username
     * @return boolean
     * */
    public function isUsername($username)
    {
        $query = $this->db->prepare("SELECT id FROM users WHERE username=:username");
        $query->bindParam("username", $username);
        $query->execute();
        if ($query->rowCount() > 0) 
        {
            return true;
        } else 
        {
            return false;
        }
    }

    /*
     * Check Email
     *
     * @param $email
     * @return boolean
     * */
    public function isEmail($email)
    {
        $query = $this->db->prepare("SELECT id FROM users WHERE email=:email");
        $query->bindParam("email", $email);
        $query->execute();
        if ($query->rowCount() > 0) 
        {
            return true;
        } 
        else
         {
            return false;
        }
    }

    /*
     * Login
     *
     * @param $username, $password
     * @return $mixed
     * */
    public function Login($username, $password)
    {
        $query = $this->db->prepare("SELECT id, password FROM users WHERE username=:username OR email=:email");
        $query->bindParam("username", $username);
        $query->bindParam("email", $username);
        $query->execute();

        if ($query->rowCount() > 0) 
        {
            $result = $query->fetch(PDO::FETCH_OBJ);
            $enc_password = $result->password;
            if (password_verify($password, $enc_password)) 
            {
                return $result->id;
            } else
             {
                return false;
            }
        } 
        else 
        {
            return false;
        }
    }

    /*
     * get User Details
     *
     * @param $user_id
     * @return $mixed
     * */
    public function UserDetails($user_id)
    {
        $query = $this->db->prepare("SELECT id, name, username, email, google_secret_code FROM users WHERE id=:user_id");
        $query->bindParam("user_id", $user_id);
        $query->execute();
        if ($query->rowCount() > 0) 
        {
            return $query->fetch(PDO::FETCH_OBJ);
        }
    }
}