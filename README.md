# Logbook 

- This application for entries required by the doctor. The entries include all daily meals

## Installation : Clone the Repository

```
 git clone https://Ngizeh@bitbucket.org/Ngizeh/logbook.git
```

Navigate to the project folder

```
 cd path/to/your/project
```

On the project folder run the following command on the terminal

```
 composer install
```

Install the project dependencies


```
 npm install && npm run dev
```

 or

 If you have yarn installed

```
 yarn install && yarn run dev
```


- Copy `.env.example` to `.env` and fill your values
(`php artisan key:generate`, configure your database and run `php artisan migrate`)

- Fill the database with seeder data, run this on the terminal
```
  php artisan db:seed

```

Finally,serve your Application on localhost:) http://localhost:8000
- If you don't have valet installed in your machine. Use this command on your terminal
```
  php artisan serve
```

