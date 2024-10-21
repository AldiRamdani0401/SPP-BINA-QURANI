<?php

class Siswa {
  private $id;
  private $fullname;
  private $email;
  private $phone;
  private $class;
  private $fatherId;
  private $fatherName;
  private $motherId;
  private $motherName;
  private $address;
  private $date_of_birth;
  private $gender;
  private $profile_picture;
  private $created_at;
  private $updated_at;

  public function __construct(
    $id = null, $fullname = null,
    $email = null, $phone = null, $class = null,
    $fatherId = null, $motherId = null,
    $fatherName = null, $motherName = null,
    $address = null, $date_of_birth = null,
    $gender = null, $profile_picture = null,
    $created_at = null, $updated_at = null
  ) {
    $this->id = $id;
    $this->fullname = $fullname;
    $this->email = $email;
    $this->phone = $phone;
    $this->class = $class;
    $this->fatherId = $fatherId;
    $this->fatherName = $fatherName;
    $this->motherId = $motherId;
    $this->motherName = $motherName;
    $this->address = $address;
    $this->date_of_birth = $date_of_birth;
    $this->gender = $gender;
    $this->profile_picture = $profile_picture;
    $this->created_at = $created_at;
    $this->updated_at = $updated_at;
  }

  // Getters
  public function getId(): mixed {
    return $this->id;
  }

  public function getFullname(): mixed {
    return $this->fullname;
  }

  public function getEmail(): mixed {
    return $this->email;
  }

  public function getPhone(): mixed {
    return $this->phone;
  }

  public function getClass(): mixed {
    return $this->class;
  }

  public function getFatherId(): mixed {
    return $this->fatherId;
  }

  public function getFatherName(): mixed {
    return $this->fatherName;
  }

  public function getMotherId(): mixed {
    return $this->motherId;
  }

  public function getMotherName(): mixed {
    return $this->motherName;
  }

  public function getAddress(): mixed {
    return $this->address;
  }

  public function getDateOfBirth(): mixed {
    return $this->date_of_birth;
  }

  public function getGender(): mixed {
    return $this->gender;
  }

  public function getProfilePicture(): mixed {
    return $this->profile_picture;
  }

  public function getCreatedAt(): mixed {
    return $this->created_at;
  }

  public function getUpdatedAt(): mixed {
    return $this->updated_at;
  }

  // Setters
  public function setId($id): void {
    $this->id = $id;
  }

  public function setFullname($fullname): void {
    $this->fullname = $fullname;
  }

  public function setEmail($email): void {
    $this->email = $email;
  }

  public function setPhone($phone): void {
    $this->phone = $phone;
  }

  public function setClass($class): void {
    $this->class = $class;
  }

  public function setFatherId($fatherId): void {
    $this->fatherId = $fatherId;
  }

  public function setFatherName($fatherName): void {
    $this->fatherName = $fatherName;
  }

  public function setMotherId($motherId): void {
    $this->motherId = $motherId;
  }

  public function setMotherName($motherName): void {
    $this->motherName = $motherName;
  }

  public function setAddress($address): void {
    $this->address = $address;
  }

  public function setDateOfBirth($date_of_birth): void {
    $this->date_of_birth = $date_of_birth;
  }

  public function setGender($gender): void {
    $this->gender = $gender;
  }

  public function setProfilePicture($profile_picture): void {
    $this->profile_picture = $profile_picture;
  }

  public function setCreatedAt($created_at): void {
    $this->created_at = $created_at;
  }

  public function setUpdatedAt($updated_at): void {
    $this->updated_at = $updated_at;
  }
}
