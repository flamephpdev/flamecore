<?php

/* <auto-generated/>
Ide Model Helper File */

namespace Core\App\Accounts
{
	class User
	{
		// Fields loaded from the database "users" table
		public $id;
		public $username;
		public $email;
		public $uniqid;
		public $email_verified_at;
		public $password;
		public $date;
	}

}

namespace App\Model
{
	class EmailVerifications
	{
		// Fields loaded from the database "email_verifications" table
		public $id;
		public $user_id;
		public $token;
		public $date;
	}

}

