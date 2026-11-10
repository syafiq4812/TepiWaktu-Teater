<?php
class User extends Connection {
    private $userid = 0;
    private $email = '';
    private $password = '';
    private $name = '';
    private $role = '';
    private $hasil = false;
    private $message = '';

    public function __get($atribute) {
        if (property_exists($this, $atribute)) {
            return $this->$atribute;
        }
    }

    public function __set($atribut, $value) {
        if (property_exists($this, $atribut)) {
            $this->$atribut = $value;
        }
    }

    public function AddUser() {
        $sql = "INSERT INTO user (email, password, name, role) VALUES (?, ?, ?, ?)";

        $stmt = mysqli_prepare($this->connection, $sql);
        mysqli_stmt_bind_param($stmt, 'ssss', $this->email, $this->password, $this->name, $this->role);

        $this->hasil = mysqli_stmt_execute($stmt);

        if ($this->hasil) {
            $this->message = 'Data berhasil ditambahkan!';
        } else {
            $this->message = 'Data gagal ditambahkan!';
        }

        mysqli_stmt_close($stmt);
        return $this->hasil;
    }

    public function ValidateEmail($inputemail) {
        $sql = "SELECT userid, email, password, name, role FROM user WHERE email = ?";

        $stmt = mysqli_prepare($this->connection, $sql);
        mysqli_stmt_bind_param($stmt, 's', $inputemail);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) == 1) {
            $this->hasil = true;
            $data = mysqli_fetch_assoc($result);

            $this->userid   = $data['userid'];
            $this->password = $data['password'];
            $this->name     = $data['name'];
            $this->email    = $data['email'];
            $this->role     = $data['role'];
        }

        mysqli_stmt_close($stmt);
    }

    // Method khusus untuk Admin
    public function ShowAllUsers() {
        $sql = "SELECT userid, email, name, role FROM user ORDER BY role ASC";
        return mysqli_query($this->connection, $sql);
    }

    public function GetUserByID($userid) {
        $sql = "SELECT userid, email, name, role FROM user WHERE userid = ?";

        $stmt = mysqli_prepare($this->connection, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $userid);
        mysqli_stmt_execute($stmt);

        return mysqli_stmt_get_result($stmt);
    }

    public function UpdateUser($userid, $nama, $email, $role) {
        $sql = "UPDATE user SET name = ?, email = ?, role = ? WHERE userid = ?";

        $stmt = mysqli_prepare($this->connection, $sql);
        mysqli_stmt_bind_param($stmt, 'sssi', $nama, $email, $role, $userid);

        $hasil = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        return $hasil;
    }

    // Method untuk menghapus data user (Admin Only)
    public function DeleteUser($userid) {
        $sql = "DELETE FROM user WHERE userid = ?";

        $stmt = mysqli_prepare($this->connection, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $userid);

        $hasil = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        return $hasil;
    }
}
