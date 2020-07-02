<?php
namespace App\Repositories\Eloquent;

use App\Models\Contact;
use App\Repositories\Contracts\IContact;

class ContactRepository extends BaseRepository implements IContact
{
    public function model()
    {
        return Contact::class;
    }



}
