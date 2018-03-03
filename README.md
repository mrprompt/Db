# Classe Db

[![Build Status](https://travis-ci.org/mrprompt/Db.svg?branch=master)](https://travis-ci.org/mrprompt/Db)
[![Maintainability](https://api.codeclimate.com/v1/badges/5c046e0c00c1a010fdf2/maintainability)](https://codeclimate.com/github/mrprompt/Db/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/5c046e0c00c1a010fdf2/test_coverage)](https://codeclimate.com/github/mrprompt/Db/test_coverage)

Db são classes simples para facilitar o uso do PDO  em pequenos projetos que
não requeiram um grande ORM ou Framework.

A classe permite que você utilize um arquivo no formato XML para armazenar
todas suas chamadas ao banco de dados, onde cada query possui seu alias e sua
conecção, permintindo assim, utilizar vários SGBDs em um mesmo projeto.
Os nós com suas consultas, podem ser utilizados como um método da classe
Db.

A classe table, permite que você crie Models, permitindo que você trabalhe
com suas tabelas como classes.

[Autor](http://about.me/mrprompt)