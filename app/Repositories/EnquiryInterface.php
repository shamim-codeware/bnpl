<?php 

namespace App\Repositories;


interface EnquiryInterface {

    public function enquiry($data);

    public function customer($data);

    public function product($data);

    public function followup($data);
}