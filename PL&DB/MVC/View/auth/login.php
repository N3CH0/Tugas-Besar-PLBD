<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Toko Ikan Hias</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="View/style.css">
</head>
<body class="login-page">
    <div class="login-card">
        <div class="login-header">
            <i class="fa-solid fa-fish"></i>
            <h1>Toko Ikan Hias</h1>
            <p>Login ke Panel Admin</p>
        </div>
        <div class="login-body">
            <?php if ($pesan !== ''): ?>
                <div class="alert-toast error">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span><?= htmlspecialchars($pesan) ?></span>
                </div>
            <?php endif; ?>
            <form action="index.php?page=login" method="post">
                <div class="form-group">
                    <label for="username">Username</label>
                    <div class="input-group">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" id="username" name="username" class="form-control" placeholder="Masukkan username" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-group">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan password">
                    </div>
                </div>
                <div class="btn-group">
                    <a href="index.php" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-right-to-bracket"></i> Login</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

