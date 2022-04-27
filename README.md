<h1 align="center">piadocas-back-end</h1>

   
<p align="center">
  <a href="#notebook-About-this-Project">About this Project</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
  <a href="#rocket-Getting-Started">Getting Started</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
  <a href="#user-content-technologies-">Technologies</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
  <a href="#mailbox-Contacts">Contacts</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;  
  <a href="#memo-license">License</a>
</p>   
   
## :notebook: About this Project

This is a project I did to see how my evolution in the PHP language has been, and it's based on a user registration with login that I made at the beginning of my studies, 
this project is an api to perform the same actions that were done in that project.
The idea is based on a social network where it is possible to get married and post boring jokes, it is also possible to interact with the posts of other users through the like.

## Technologies 🐱‍🏍🎂

- [PHP](https://www.php.net/) - Language
- [Composer](https://getcomposer.org/) dependency management
- [MySQL](https://www.mysql.com/) Database
- [Apache](https://www.apache.org) Server http


### Installing

**Installing dependencies**

```bash
composer install
```
or 

```bash
php composer.phar install
```

it is necessary to create a database identical to the one in **src/Database/database.sql**

### Running

- An apache server is needed to run the same
- The project index will be inside src so this will be the application root

## What do routes do?

For 'Piadocas' I created two main routes that deal with '/user/' and '/post/' that deal with users and posts respectively.

### user

- localhost/src/**`api`**/**`user`**/**`select`** - 
- localhost/src/**`api`**/**`user`**/**`select`**&`id`=1 - Returns all users registered in the database.
- localhost/src/**`api`**/**`user`**/**`create`**&`name`=pedro&`email`=pedro@augusto.com&`password`=123 - Register a new user.
- localhost/src/**`api`**/**`user`**/**`update`**&`iduser`=1&`name`=florentino&`email`=augusto@pedro.com&`password`=234 - Updates the user data, being mandatory only the iduser and some of the other parameters that will be updated.
- localhost/src/api/**`user`**/**`delete`**&`iduser`=1&`email`=pedro@augusto.com&`password`=123 - Delete a user.
- localhost/src/api/**`user`**/**`login`**&`email`=pedro@augusto.com&`password`=123 - Authenticates user data.

### poset

- localhost/src/**`api`**/**`post`**/**`select`** - Returns all posts registered in the database.
- localhost/src/**`api`**/**`post`**/**`select`**&`id`=1 - Returns a specific post.
- localhost/src/**`api`**/**`post`**/**`create`**&`iduser`=1&`post`='O que o pato disse para a pata? R.: Vem Quá!' - Register a new post.
- localhost/src/**`api`**/**`post`**/**`update`**&`iduser`=1&`IdPost`=1&`post`='O que é o que é' - Update a post.
- localhost/src/**`api`**/**`post`**/**`delete`**&`idpost`=1&`email`=pedro@augusto.com&`password`=123 - Deletr a post.
- localhost/src/**`api`**/**`post`**/**`like`**&`iduserlike`=1&`idpost`=1 - Interact with a post through the like.


------------------
## License

MIT [LICENSE](LICENSE.md)
