<?php
class Tools
{
    static function connect(
        $host = 'localhost',
        $user = 'root',
        $pass = '',
        $dbname = 'shopdb'
    ){
        $cs = "mysql:host=$host;dbname=$dbname;charset=utf8";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES UTF8',
        ];
        try{
            $pdo = new PDO($cs, $user, $pass, $options);
            return $pdo;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
            return false;
        }
    }
    static function register($login, $password, $imagepath)
    {
        $login = trim(htmlspecialchars($login));
        $password = trim(htmlspecialchars($password));
        $imagepath = trim(htmlspecialchars($imagepath));
        if ($login == '' || $password == '') {
            Tools::Logging("Fill All Required Fields");
        }
        $password = md5($password);
        Tools::connect();
        $customer = new Customer($login, md5($password), $imagepath);
        $err = $customer->intoDb();
        if ($err){
            if ($err == 1062){
                Tools::Logging('Error');
            }
        }
        return true;
    }
    static function Logging($text, $is_error = true)
    {
        echo "<h2 style= color:$is_error ? 'red' : 'green'>$text</h2>";
        return $is_error ? false : '';
    }
}

class Customer
{
    protected $id;
    protected $login;
    protected $pass;
    protected $role_id;
    protected $discount;
    protected $total;
    protected $imagepath;

    public function __construct($login, $pass, $imagepath, $id = 0)
    {
        $this->login = $login;
        $this->pass = $pass;
        $this->imagepath = $imagepath;
        $this->id = $id;
        $this->total = 0;
        $this->discount = 0;
        $this->role_id = 2;
    }

    function intoDb()
    {
        try {
            $pdo = Tools::connect();
            $ps = $pdo->prepare("insert INTO Customer(login, pass, role_id, discount, total, imagepath)
                                             VALUES (:login, :pass, :role_id, :discount, :total, :imagepath)");
            $ps->execute([
                'login' => $this->login,
                'pass' => $this->pass,
                'role_id' => $this->role_id,
                'discount' => $this->discount,
                'total' => $this->total,
                'imagepath' => $this->imagepath
            ]);
        } catch (PDOException $ex) {
            $err = $ex->getMessage();
            if (substr($err, 0, strpos($err, ":")) == 'SQLSTATE[23000]:Integrity constraint violation') {
                return 1062;
            } else {
                return $ex->getMessage();
            }
        }
    }

    function fromDb($id)
    {
        $customer = null;
        try {
            $pdo = Tools::connect();
            $ps = $pdo->prepare("select * from Customers where id = ?");
            $res = $ps->execute([$id]);
            $row = $res->fetch();
            $customer = new Customer($row['login'], $row['pass'], $row['imagepath'], $row['id']);
            return $customer;
        } catch (PDOException $ex){
            echo $ex->getMessage();
            return false;
        }
    }
}
