<div class="row">
	<div class="col-lg-12" align="left">
    <table class="table table-striped">
      <thead >
        <tr>
          <th scope="col">ID:</th>
          <th scope="col">Title:</th>
          <th scope="col">Customer:</th>
          <th scope="col">Skype:</th>
          <th scope="col">Phones,emails:</th>
          <th scope="col">VK / FB:</th>
          <th scope="col">Price:</th>
          <th scope="col">Start / End:</th>
          <th scope="col">Day:</th>
        </tr>
        </thead>
        <tbody>
<?php 
        $projects = $pure->getAllProjects();

        foreach($projects as $project) {
            
        //$project['done'] 
            if ($project['currency'] == 0) {
                $currency = '$';
            } elseif ($project['currency'] == 1) {
                $currency = '₽';
            } elseif ($project['currency'] == 2) {
                $currency = '₴';
            } 
            
            $days = $project['workEnd'] - mktime();
            $days = round(($days / 60 / 60 / 24),2);
            $hours = floor(($days - floor($days)) * 24);
?>         
                <tr>
                <th scope="row"><?php echo $project['ID']; ?></th>
                <td><a href="<?php echo configuration::MAIN_URL;?>?page=project&id=<?php echo $project['ID']; ?>"><?php echo $project['title']; ?></a></td>
                <td><?php echo $project['customer']; ?></td>
                <td><?php echo $project['skype']; ?></td>
                <td>
                <?php echo strlen($project['phone1']) > 0 ? $project['phone1'].'<br>' : ''; ?>
                <?php echo strlen($project['phone2']) > 0 ? $project['phone2'].'<br>' : ''; ?>
                <?php echo strlen($project['phone3']) > 0 ? $project['phone3'].'<br>' : ''; ?>
                <?php echo strlen($project['email1']) > 0 ? $project['email1'].'<br>' : ''; ?>
                <?php echo strlen($project['email2']) > 0 ? $project['email2'].'<br>' : ''; ?>
                </td>
                <td><a href="<?php echo $project['vk']; ?>" target="_blank">vk</a> / 
                <a href="<?php echo $project['fb']; ?>" target="_blank">fb</a></td>
                <td><?php echo $project['price'].$currency; ?></td>
                <td><?php echo date("Y-m-d", $project['workBegin']); ?><br>
                <?php echo date("Y-m-d", $project['workEnd']); ?></td>
                <td><?php echo floor($days); ?> d. <?php echo $hours; ?> h.</td>
                <tr>
<?php
        }
?>
        </tbody>
</table>
        <p align="left">Створюю новий проект і всю інформацію про нього зберігаю туди, включаючи те, 
        що вводить користувач, посилання на відео конференції з клієнтом і телефонні розмови.</p>
        <?php 
            $question1 = array(
                'Яка ціль створення сайту? Щоби що отримати?',
                'Про кого цей сайт, хто герой?',
                'Чим займається герой, чим він корисний?',
                'Кому корисний герой?',
                'Що він пропонує і на яких умовах?',
                'Які є способи отримати це від героя?'
            
            );
             $question2 = array(
                'Які обовязкові елементи потрібні, без яких сайт не може існувати?',
                'Які додаткові елементи будуть корисними?',
                'Які елементи некорисні на сайті?',
                'Скільки часу треба потратити на виготовлення кожного елементу?',
                'Який мінімальний і максимальний час роботи?',
                'Яка вартість роботи?',
                'Які є етапи роботи?'
            
            );
            echo '<pre>';
            print_r($question1);
            echo '</pre>';
            echo '<pre>';
            print_r($question2);
            echo '</pre>';
        ?>
        <p>Потім можна згенерувати документ PDF як технічне завдання на розробку сайту.</p>
        <br>
        <h3>Висилаю на пошту і пишу:</h3>
        <p align="left">
        Висилаю вам цей pdf документ, щоб ви могли дізнатись як саме буде розроблятись ваш сайт.<br>
        Якщо ви не хочете витрачати свій час на всі ці технічні питання, то можете просто оплачувати роботу.
        <br>Ви можете мені довіряти. Я зроблю для вас хороший сайт. 
        <br>Ось посилання для оплати послуг:
        <ul align="left"> 
        <li>Оплатити через: <a href="">ПриватБанк</a></li>
        <li>Оплатити через: <a href="">Карту Wisa/Mastercard</a></li>
        <li>Оплатити через: <a href="">Яндекс.Деньги</a><br></li>
        <li>Оплатити через: <a href="">WebMoney</a></li>
        </ul>
        </p>
        <p align="left">
        Сума до оплати: 10000 грн
        </p>
        <h3>Сторінка на які клієнт буде записувати свої дані:</h3>
    <p>Ця сторінка створеня для того, щоб полегшити нам з вами роботу. Відповідаючи на запитання не поспішайте. 
    Якщо ви не знаєте як відповісти, або не хочете цього робити, то поставте відповідну галочку.
    
    </p>
    </div>
</div>



