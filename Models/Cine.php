<?php
use Models\Room as Room;
namespace Models;
    class Cine{
        private $id;
        private $Name;
        private $Address;
        private $Capacity;
        private $Value;
        private $Rooms=[];

        
        public function getId()
        {
                return $this->id;
        }


        public function setId($id)
        {
                $this->id = $id;
        }

        public function getName()
        {
                return $this->Name;
        }


        public function setName($name)
        {
                $this->Name = $name;
        }

        public function getAddress()
        {
                return $this->Address;
        }

        public function setAddress($address)
        {
                $this->Address = $address;
        }

        public function getCapacity()
        {
                $this->Capacity=0;
                foreach($this->Rooms as $room){
                        $this->Capacity+=$room->getCapacity();
                }
                return $this->Capacity;
        }

        public function getValue()
        {
                return $this->Value;
        }
     
        public function setValue($value)
        {
                $this->Value = $value;
        }

        public function getRooms()
        {
                return $this->Rooms;
        }

        public function setRooms($Rooms)
        {
                $this->Rooms = $Rooms;

        }

        public function addRoom($room){
                array_push($this->Rooms,$room);
        }

    }

?>