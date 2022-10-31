<?php

namespace Modules\User\Entities\Builder;

use App\Models\BaseBuilder;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Entities\User;

class UserBuilder extends BaseBuilder
{

    public function __construct()
    {
        $this->_model = User::query();
    }

    public function type($type)
    {
        if(!empty($type))
        {
            $this->_model->where('type', $type);
        }
        return $this;
    }

    public function username($username)
    {
        if(!empty($username))
        {
            $this->_model->where('username', $username);
        }
        return $this;
    }

    public function email($email)
    {
        if(!empty($email))
        {
            $this->_model->where('email', $email);
        }
        return $this;
    }

    public function createdAt($createdAt)
    {
        if(!empty($createdAt))
        {
            $this->_model->where('created_at', $createdAt);
        }
        return $this;
    }

    public function role($role)
    {
        if(!empty($role))
        {
            $this->_model->where('role', $role);
        }
        return $this;
    }

    public function address($address)
    {
        if(!empty($address))
        {
            $this->_model->where('address', $address);
        }
        return $this;
    }

    public function package($package)
    {
        if(!empty($package))
        {
            $this->_model->where('package', $package);
        }
        return $this;
    }

    public function registerBetween($startDate, $endDate)
    {
        if(!empty($startDate) && !empty($endDate))
        {
            $this->_model->whereBetween('created_at', [
                Carbon::parse($startDate),
                Carbon::parse($endDate),
            ]);
        }
        return $this;
    }

    public function registerBeforeDate($date)
    {
        if(!empty($date))
        {
            $this->_model->where('created_at', '<', Carbon::parse($date));
        }
        return $this;
    }
}
