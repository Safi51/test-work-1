## Как запустить проект
1) Скопировать test_work/.env.example и test_work/safi_test_work/.env.example и вставить без **/.example**
2) Запустить docker compose up -d
3) docker ps и найти Container Id с image laravel_app:latest
4) Написать команду в терминал docker exec -it Container Id bash
5) php artisan migrate
6) Для просмотра бд можете перейти [Adminer](http://localhost:8080)
---
**Если вы скопировали и вставили без изменений можете ввести тоже что и на фото с паролем в .env/DB_PASSWORD**
---

   <img width="484" height="270" alt="image" src="https://github.com/user-attachments/assets/bef363b5-0831-4613-a809-3f556a0c8934" />
---

### Написал тест на поплнение баланса. Думаю этого достаточно
