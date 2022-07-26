## Project setups on local machine
Visit this link -  http://chntest-33154.camry.chost.com.ua or set up the project locally following the next steps:
1. clone the project from the repository - https://github.com/IgorOleniuk/mortage_banks
2. enter the project folder
3. run composer install
4. create .env and copy .env.example
5. run php artisan key:generate
6. add DB info in .env file
7. run php artisan migrate
8. run npm install && npm run dev
9. run php artisan:serve

### Bonus tasks
Deploy the application to make it available through the Internet. http://chntest-33154.camry.chost.com.ua/  ✅
Create a README file with a project setup instruction. - ✅
Implement bank loan history. If a user tried to calculate a mortgage you can keep this record in the database and show this record in the history of the specific bank. - ✅

