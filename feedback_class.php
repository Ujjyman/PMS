<?php

namespace core\user;

class feedback
{
    public $id;
    public $id_patient;
    public $rate;
    public $comment;
    public $date_created;

    function __construct($id_patient, $rate, $comment, $date_created)
    {
        $this->id_patient = $id_patient;
        $this->rate = $rate;
        $this->comment = $comment;
        $this->date_created = $date_created;
    }
}