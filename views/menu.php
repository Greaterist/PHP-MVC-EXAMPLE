<?php
if ($isAuth): ?>
    Добро пожаловать <?= $userName ?> <a href="/auth/logout">[Выход]</a>
<?php else: ?>
    <form action="/auth/login" method="post">
        <input type="text" name="login" placeholder="Логин" value="admin">
        <input type="text" name="pass" placeholder="Пароль" value="12345">
        <input type="submit" name="submit" value="Войти">
    </form>
<?php endif; ?><br>

<a href="/">Главная</a>
<a href="/goods/catalog">Каталог</a><br>
<a href="/basket">Корзина (<span id="count"><?=$count?></span>)</a><br>
<a href="/orders">Заказы</a><br>