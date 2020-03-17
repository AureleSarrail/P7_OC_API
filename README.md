# P7_OC
Create an API in order to provide informations to customers

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/dd03f213a31346e599b6fb4fbf6fd098)](https://www.codacy.com/manual/AureleSarrail/P7_OC_API?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=AureleSarrail/P7_OC_API&amp;utm_campaign=Badge_Grade)

<a href="https://codeclimate.com/github/AureleSarrail/P7_OC_API/maintainability"><img src="https://api.codeclimate.com/v1/badges/039463b53bd1b387c379/maintainability" /></a>

# Installation #
To install the project, you can clone this repository to your computer.

In your project and in the console, type : composer install.
That will install all the required bundle.

Next step is to configure your .env file with your database info.

That made, you will have to create the database and do the migrations :
- php bin\console doctrine:migrations:migrate

The security is Based on LexikJWT so you will have to install and configure that bundle.
You can find documentation here : https://github.com/lexik/LexikJWTAuthenticationBundle

Thanks for reading this.
