# [PHPVote](https://php-vote.com)

Community website powered by the Symfony 4 & PHP.  
PHPVote is a platform where people can share and discuss their idea to improve the PHP language

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development.

### Prerequisites

Some Symfony knowledges are recommended.  
You should run this projet with PHP 7.2 
```
php -v
PHP 7.2.8-1+0~20180725124257.2+stretch~1.gbp571e56 (cli) (built: Jul 25 2018 12:43:00) ( NTS )
Copyright (c) 1997-2018 The PHP Group
Zend Engine v3.2.0, Copyright (c) 1998-2018 Zend Technologies
    with Zend OPcache v7.2.8-1+0~20180725124257.2+stretch~1.gbp571e56, Copyright (c) 1999-2018, by Zend Technologies
    with Xdebug v2.6.0, Copyright (c) 2002-2018, by Derick Rethans
    with blackfire v1.22.0~linux-x64-non_zts72, https://blackfire.io, by Blackfire
```

Be sure to have a least Node.js v10.7.0 (use [nvm](https://github.com/creationix/nvm) to have multiple versions of node)
```
node -v
```
Be sure to also have composer installed (locally or globally) :
```
composer --version
Composer version 1.7.0 2018-08-03 15:39:07
```

### Installing
 
Set up your environment. All of thoses commands have to be done in the projet root.

Configure you ```.env``` file (I only put important values here) :
```
APP_ENV=dev
APP_SECRET=thisissecretchangeit
DATABASE_URL=mysql://user:password@127.0.0.1:3306/your-db-name
```

Install PHP vendor
```
composer install
```

Install JS deps
```
npm install
```

Run the migrations
```
bin/console doctrine:migration:migrate
```

Start the assets watcher
```
npm run dev-server
```

Start the local dev server
```
bin/console server:start
```
You will get a message like : ``` [OK] Server listening on http://127.0.0.1:8000```

