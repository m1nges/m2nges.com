<?php 
include '../includes/header.php';

// Обработка формы
$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получение и очистка данных
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');
    
    // Валидация
    if (empty($name)) {
        $errors['name'] = 'Пожалуйста, введите ваше имя';
    }
    
    if (empty($email)) {
        $errors['email'] = 'Пожалуйста, введите ваш email';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Пожалуйста, введите корректный email';
    }
    
    if (empty($message)) {
        $errors['message'] = 'Пожалуйста, введите ваше сообщение';
    } elseif (strlen($message) < 10) {
        $errors['message'] = 'Сообщение должно содержать не менее 10 символов';
    }
    
    // Если ошибок нет - отправляем email
    if (empty($errors)) {
        $to = 'your@example.com'; // Замените на ваш email
        $subject = 'Новое сообщение с сайта от ' . $name;
        $headers = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "Content-Type: text/plain; charset=utf-8\r\n";
        
        $emailBody = "Имя: $name\nEmail: $email\n\nСообщение:\n$message";
        
        if (mail($to, $subject, $emailBody, $headers)) {
            $success = true;
            // Очищаем поля после успешной отправки
            $name = $email = $message = '';
        } else {
            $errors['general'] = 'Произошла ошибка при отправке сообщения. Пожалуйста, попробуйте позже.';
        }
    }
}
?>

<style>
    :root {
        --primary-color: #4a6fa5;
        --secondary-color: #166088;
        --accent-color: #4fc3f7;
        --error-color: #e74c3c;
        --success-color: #2ecc71;
        --text-color: #333;
        --light-gray: #f5f5f5;
        --border-radius: 8px;
        --box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    main {
        max-width: 800px;
        margin: 2rem auto;
        padding: 2rem;
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
    }
    
    h1 {
        color: var(--secondary-color);
        text-align: center;
        margin-bottom: 2rem;
    }
    
    .contact-form {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }
    
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .form-group label {
        font-weight: 600;
        color: var(--secondary-color);
    }
    
    .form-control {
        padding: 0.8rem 1rem;
        border: 1px solid #ddd;
        border-radius: var(--border-radius);
        font-size: 1rem;
        transition: border 0.3s ease;
    }
    
    .form-control:focus {
        outline: none;
        border-color: var(--accent-color);
        box-shadow: 0 0 0 3px rgba(79, 195, 247, 0.2);
    }
    
    textarea.form-control {
        min-height: 150px;
        resize: vertical;
    }
    
    .btn {
        background-color: var(--primary-color);
        color: white;
        border: none;
        padding: 1rem 2rem;
        border-radius: var(--border-radius);
        font-size: 1rem;
        cursor: pointer;
        transition: background-color 0.3s ease;
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 1px;
    }
    
    .btn:hover {
        background-color: var(--secondary-color);
    }
    
    .alert {
        padding: 1rem;
        border-radius: var(--border-radius);
        margin-bottom: 1.5rem;
        font-weight: 500;
    }
    
    .alert-success {
        background-color: rgba(46, 204, 113, 0.2);
        color: var(--success-color);
        border: 1px solid var(--success-color);
    }
    
    .alert-error {
        background-color: rgba(231, 76, 60, 0.2);
        color: var(--error-color);
        border: 1px solid var(--error-color);
    }
    
    .error-message {
        color: var(--error-color);
        font-size: 0.9rem;
        margin-top: 0.25rem;
    }
    
    @media (max-width: 768px) {
        main {
            margin: 1rem;
            padding: 1.5rem;
        }
    }
</style>

<main>
    <h1>Свяжитесь с нами</h1>
    
    <?php if ($success): ?>
        <div class="alert alert-success">
            Спасибо за ваше сообщение! Мы свяжемся с вами в ближайшее время.
        </div>
    <?php elseif (isset($errors['general'])): ?>
        <div class="alert alert-error">
            <?php echo htmlspecialchars($errors['general']); ?>
        </div>
    <?php endif; ?>
    
    <form method="post" class="contact-form">
        <div class="form-group">
            <label for="name">Ваше имя</label>
            <input 
                type="text" 
                name="name" 
                id="name" 
                class="form-control <?php echo isset($errors['name']) ? 'is-invalid' : ''; ?>" 
                value="<?php echo htmlspecialchars($name ?? ''); ?>"
                placeholder="Введите ваше имя"
            >
            <?php if (isset($errors['name'])): ?>
                <span class="error-message"><?php echo htmlspecialchars($errors['name']); ?></span>
            <?php endif; ?>
        </div>
        
        <div class="form-group">
            <label for="email">Email адрес</label>
            <input 
                type="email" 
                name="email" 
                id="email" 
                class="form-control <?php echo isset($errors['email']) ? 'is-invalid' : ''; ?>" 
                value="<?php echo htmlspecialchars($email ?? ''); ?>"
                placeholder="Введите ваш email"
            >
            <?php if (isset($errors['email'])): ?>
                <span class="error-message"><?php echo htmlspecialchars($errors['email']); ?></span>
            <?php endif; ?>
        </div>
        
        <div class="form-group">
            <label for="message">Ваше сообщение</label>
            <textarea 
                name="message" 
                id="message" 
                class="form-control <?php echo isset($errors['message']) ? 'is-invalid' : ''; ?>" 
                placeholder="Напишите ваше сообщение здесь..."
            ><?php echo htmlspecialchars($message ?? ''); ?></textarea>
            <?php if (isset($errors['message'])): ?>
                <span class="error-message"><?php echo htmlspecialchars($errors['message']); ?></span>
            <?php endif; ?>
        </div>
        
        <button type="submit" class="btn">Отправить сообщение</button>
    </form>
</main>

<?php include '../includes/footer.php'; ?>