
Conversa aberta. Uma mensagem lida.


Pular para o conteúdo
Como usar o Gmail com leitores de tela
46 de 2.145
Documentação dos componentes Model e Route
Caixa de entrada

GIOVANNI ALVES DE LIMA OLIVEIRA <galo1@aluno.ifal.edu.br>
Anexos
seg., 29 de ago. 15:17
para mim

   
Traduzir mensagem
Desativar para: inglês

2 anexos
# Model - @LandKit

The model is a persistent abstraction component of your database that PDO has prepared instructions for performing
common routines such as registering, reading, editing, and removing data.

## Installation

Model is available via Composer:

```bash
"landkit/php8-model": "1.0.*"
```

or run

```bash
composer require landkit/php8-model
```

## Documentation

#### connection

To begin using the Model, you need to connect to the database (MariaDB / MySql). For more
connections [PDO connections manual on PHP.net](https://www.php.net/manual/pt_BR/pdo.drivers.php)

```php
const CONF_DATABASE = [
    "default" => [
        "driver" => "mysql",
        "host" => "localhost",
        "port" => "3306",
        "dbname" => "model_example",
        "username" => "root",
        "passwd" => "",
        "options" => [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_CASE => PDO::CASE_NATURAL
        ]
    ]
];
```

#### your model

The Model is based on an MVC structure with the Layer Super Type and Active Record design patterns. Soon to consume it
is necessary to create the model of your table and inherit the Model.

```php
<?php

class User extends Model
{
    /**
     * Set table name (required)
     * 
     * @var string $table
     */
    protected string $table = "users";
     
    /**
     * Set primary key (optional) (default: id)
     * 
     * @var string $primaryKey
     */
    protected string $primaryKey = "id";
    
    /**
     * Set as required columns (optional)
     * Must be used when there are columns that cannot be null (NOT NULL) 
     * 
     * @var array $required (default: [])
     */
    protected array $required = [
        "first_name",
        "last_nae"
    ];
    
    /**
     * Set timestamp (optional) (default: true)
     *
     * If there are "created_at" and "updated_at" columns, you can set $timestamps to true.
     * If neither exists, set $timestamps to false.
     * If there is only one of the two, set $timestamps to true. 
     * 
     * @var bool $timestamps
     */
    protected bool $timestamps = true;
    
    /**
     * Set created_at column (optional) (default: created_at)
     * If there is a column with a name other than "created_at", you can replace the value of "CREATED_AT" with the column name.
     * 
     * Note for the constants "CREATED_AT" and "UPDATED_AT".
     * If only one column exists, it is necessary to leave the value blank for the other one.
     * 
     * @const string
     */
    const CREATED_AT = "created_at";
    
    /**
     * Set updated_at column (optional) (default: updated_at)
     * If there is a column with a name other than "updated_at", you can replace the value of "UPDATED_AT" with the column name.
     * 
     * Note for the constants "CREATED_AT" and "UPDATED_AT".
     * If only one column exists, it is necessary to leave the value blank for the other one.
     *
     * @const string
     */
    const UPDATED_AT = "updated_at";
}
```

#### find

```php
<?php

use Example\Models\User;

$model = new User();

//find all users
$users = $model->select('*')->fetch(true);

//find all users limit 2
$users = $model->select('*')->limit(2)->fetch(true);

//find all users limit 2 offset 2
$users = $model->select('*')->limit(2)->offset(2)->fetch(true);

//find all users limit 2 offset 2 order by field ASC
$users = $model->select('*')->limit(2)->offset(2)->order("first_name ASC")->fetch(true);

//looping users
foreach ($users as $user) {
    echo $user->first_name;
}

//find one user by condition
$user = $model->where("first_name = :name", "name=Land")->fetch();
echo $user->first_name;

//find one user by two conditions
$user = $model->where("first_name = :name AND last_name = :last", "name=Land&last=Kit")->fetch();
echo $user->first_name . " " . $user->first_last;
```

#### findById

```php
<?php

use Example\Models\User;

$model = new User();
$user = $model->findById(2);
echo $user->first_name;
```

#### findById

```php
<?php

use Example\Models\User;

$model = new User();
$user = $model->findByPrimaryKey(1);
echo $user->first_name;
```

#### secure params

```php
<?php

$params = http_build_query(["name" => "LandKit & Associated"]);
$company = (new Company())->where("name = :name", $params);
var_dump($company, $company->fetch());
```

#### join method

```php
<?php

$addresses = new Address();
$address = $addresses->findById(22);
//get user data to this->user->[all data]
$address->user();
var_dump($address);
```

#### count

```php
<?php

use Example\Models\User;

$model = new User();
$count = $model->select('*')->count();
```

#### save

```php
<?php

use Example\Models\User;

$user = new User();
$user->first_name = "Land";
$user->last_name = "Kit";
$user->save();
```

#### save update

```php
<?php

use Example\Models\User;

$user = (new User())->findById(2);
$user->first_name = "Land";
$user->save();
```

#### destroy

```php
<?php

use Example\Models\User;

$user = (new User())->findById(2);
$user->destroy();
```

#### fail

```php
<?php

use Example\Models\User;

$user = (new User())->findById(2);
if($user->fail()){
    echo $user->fail()->getMessage();
}
```

#### custom data method

````php
<?php

class User{

    public function fullName(): string 
    {
        return "{$this->first_name} {$this->last_name}";
    }
    
    public function document(): string
    {
        return "Restrict";
    }
}

echo $this->full_name; //Land Kit
echo $this->document; //Restrict
````
MODEL.md
Mais zoom aplicado ao item.