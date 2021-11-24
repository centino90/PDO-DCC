<?php
class Clinic
{
  private $db;

  public function __construct()
  {
    $this->db = new Database;
  }

  // Regsiter user
  public function store($data)
  {
    $user = $this->getRowWithValue('users', 'email', $data['email']);

    $this->db->query(
      'INSERT INTO clinics 
        (
          user_id, name, street, district, city, contact_number
        ) 
      VALUES
        (
          :user_id, :name, :street, :district, :city, :contact_number
        )
      '
    );

    $this->db->bind(':user_id', $user->id);
    $this->db->bind(':name', $data['clinic_name']);
    $this->db->bind(':street', $data['clinic_street'] ?? '');
    $this->db->bind(':district', $data['clinic_district'] ?? '');
    $this->db->bind(':city', $data['clinic_city'] ?? '');
    $this->db->bind(':contact_number', $data['clinic_contact_number'] ?? '');

    // Execute
    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }

  public function updateOrInsert($data)
  {
    if ($this->findClinicById($data['user_id'])) {
      $this->db->query(
        'UPDATE clinics 
        SET
          name = :name, street = :street, district = :district, city = :city, contact_number = :contact_number
        WHERE user_id = :user_id
        '
      );

      $this->db->bind(':user_id', $data['user_id']);
      $this->db->bind(':name', $data['clinic_name']);
      $this->db->bind(':street', $data['clinic_street']);
      $this->db->bind(':district', $data['clinic_district']);
      $this->db->bind(':city', $data['clinic_city']);
      $this->db->bind(':contact_number', $data['clinic_contact_number']);

      if ($this->db->execute()) {
        return true;
      } else {
        return false;
      }
    }

    $this->db->query(
      'INSERT INTO clinics 
      (user_id, name, street, district, city, contact_number)
      VALUES
      (:user_id, :name, :street, :district, :city, :contact_number)
      '
    );

    $this->db->bind(':name', $data['clinic_name']);
    $this->db->bind(':street', $data['clinic_street']);
    $this->db->bind(':district', $data['clinic_district']);
    $this->db->bind(':city', $data['clinic_city']);
    $this->db->bind(':contact_number', $data['clinic_contact_number']);
    $this->db->bind(':user_id', $data['user_id']);

    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }

  public function updateAdditionalInfo($data)
  {
    $this->db->query(
      'UPDATE users 
       SET
        middle_name = :middle_name, prc_number = :prc_number, contact_number = :contact_number, birthdate = :birthdate, address = :address
      '
    );

    $this->db->bind(':middle_name', $data['middle_name']);
    $this->db->bind(':prc_number', $data['prc_number']);
    $this->db->bind(':contact_number', $data['contact_number']);
    $this->db->bind(':birthdate', $data['birthdate']);
    $this->db->bind(':address', $data['address']);

    // Execute
    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }

  // Find clinic by id
  public function findClinicById($id)
  {
    $this->db->query('SELECT * FROM clinics WHERE user_id = :user_id');
    $this->db->bind(':user_id', $id);

    $row = $this->db->single();

    if ($this->db->rowCount() > 0) {
      return true;
    } else {
      return false;
    }
  }

  // Get User by ID
  public function getClinicById($id)
  {
    $this->db->query('SELECT * FROM clinics WHERE user_id = :id');
    // Bind value
    $this->db->bind(':id', $id);

    $row = $this->db->single();

    return $row;
  }

  public function getRowWithValue($table, $column, $value)
  {
    $sql = 'SELECT * FROM ' . $table . ' WHERE ' . $column . ' = :' . $column;
    $this->db->query($sql);
    // Bind value
    $this->db->bind(':' . $column, $value);

    $row = $this->db->single();

    return $row;
  }

  function updateRowById($table, $column, $value, $id)
  {
    $sql = 'UPDATE ' . $table . ' SET ' . $column . ' = :' . $column . ' WHERE id = :id';
    $this->db->query($sql);

    $this->db->bind(':' . $column, $value);
    $this->db->bind(':id', $id);

    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }
}
