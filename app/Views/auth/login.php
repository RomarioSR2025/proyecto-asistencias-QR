<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - IEP Horacio Zeballos Gámez</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
html, body {
    margin:0; padding:0;
    height:100%; width:100%;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    overflow: hidden;
}

body {
    display: flex;
    justify-content: center;
    align-items: center;
    background: #f5f5dc;
}

.dynamic-bg {
    position: fixed;
    top:0; left:0;
    width:100%; height:100%;
    background: url("<?= base_url('uploads/horacios01.jpeg') ?>") no-repeat center center;
    background-size: cover;
    z-index: -2;
    filter: blur(5px);
    animation: bgAnimation 20s infinite alternate;
}

@keyframes bgAnimation {
    0% { transform: scale(1) translateY(0); filter: blur(4px); }
    50% { transform: scale(1.05) translateY(-10px); filter: blur(5px); }
    100% { transform: scale(1) translateY(0); filter: blur(4px); }
}

.overlay {
    position: fixed; top:0; left:0;
    width:100%; height:100%;
    background-color: rgba(245,245,220,0.5);
    backdrop-filter: blur(6px);
    z-index: -1;
}

.login-container {
    position: relative; z-index: 1;
    width: 100%;
    max-width: 420px;
    padding: 15px;
    opacity: 0;
    transform: translateY(30px);
    animation: fadeUp 1s ease forwards;
}

@keyframes fadeUp {
    to { opacity: 1; transform: translateY(0); }
}

.card {
    border-radius: 1rem;
    overflow: hidden;
    box-shadow: 0 15px 35px rgba(0,0,0,0.3);
    background-color: rgba(255,255,255,0.9);
}

.card-header {
    background-color: #800020; 
    color: #f5f5dc;
    font-weight: bold;
    font-size: 1.3rem;
    text-align: center;
    padding: 1.2rem;
}

.card-footer {
    background-color: #f5f5dc;
    color: #800020;
    font-size: 0.875rem;
    text-align: center;
    padding: 0.8rem;
}

.logo {
    width: 130px;
    display: block;
    margin: 0 auto 15px auto;
}

/* Floating labels estilo Material Design */
.form-floating>.form-control:focus~label,
.form-floating>.form-control:not(:placeholder-shown)~label {
    transform: translateY(-1.6rem) scale(0.85);
    color: #800020;
}
.form-floating>label {
    position: absolute;
    top:0.75rem; left:0.75rem;
    padding:0 0.25rem;
    transition: all 0.3s ease;
    pointer-events:none;
    color:#555;
    background-color: rgba(255,255,255,0.9);
}

.form-control {
    border-radius:0.7rem; 
    padding:1rem 0.75rem 0.25rem 0.75rem;
    transition: all 0.3s ease;
    opacity: 0;
    transform: translateX(-30px);
    animation: slideIn 0.6s forwards;
}

.form-control:focus {
    border-color:#800020;
    box-shadow:0 0 10px rgba(128,0,32,0.4);
}

@keyframes slideIn {
    to { opacity:1; transform: translateX(0); }
}

/* Botón con ripple effect */
.btn-primary {
    position: relative;
    overflow: hidden;
    background-color: #800020;
    border: none;
    font-weight: bold;
    transition: all 0.3s ease;
}
.btn-primary:hover { background-color: #4d0011; }
.btn-primary:after {
    content:"";
    position:absolute;
    width:100px; height:100px;
    background:rgba(255,255,255,0.4);
    display:block;
    transform:scale(0);
    border-radius:50%;
    opacity:0;
    pointer-events:none;
}
.btn-primary:active:after { animation: ripple 0.6s linear; }
@keyframes ripple { to { transform: scale(4); opacity:0; } }

/* Animación de mensajes de error */
.alert {
    opacity: 0;
    animation: fadeInAlert 0.8s forwards;
}
@keyframes fadeInAlert { to { opacity: 1; } }

.password-toggle {
    position: absolute;
    top: 50%;
    right: 12px;
    transform: translateY(-50%);
    cursor: pointer;
    color: #800020;
}

@media (max-width: 576px) {
    .login-container { max-width: 95%; padding: 10px; }
    .card-header { font-size: 1.2rem; padding: 1rem; }
}
</style>
</head>
<body>

<div class="dynamic-bg"></div>
<div class="overlay"></div>

<div class="login-container">
    <div class="card">
        <div class="card-header">
            <img src="<?= base_url('uploads/horacios02.jpg') ?>" alt="Logo Colegio" class="logo">
            Iniciar Sesión
        </div>
        <div class="card-body p-4">

            <?php if(session()->getFlashdata('error')): ?>
                <div class="alert alert-danger text-center" id="login-error">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('login') ?>" method="post" id="loginForm">
                <?= csrf_field() ?>

                <div class="form-floating mb-3">
                    <input type="text" name="nomuser" id="nomuser" class="form-control" 
                           placeholder="Usuario" value="<?= old('nomuser') ?>" 
                           required autofocus style="animation-delay:0.2s;">
                    <label for="nomuser">Usuario</label>
                </div>

                <div class="form-floating mb-3 position-relative">
                    <input type="password" name="passuser" id="passuser" class="form-control" 
                           placeholder="Contraseña" required style="animation-delay:0.4s;">
                    <label for="passuser">Contraseña</label>
                    <span class="password-toggle" onclick="togglePassword()">👁️</span>
                </div>

                <div class="d-grid mt-3">
                    <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">Ingresar</button>
                </div>
            </form>

        </div>
        <div class="card-footer">
            &copy; <?= date('Y') ?> IEP Horacio Zeballos Gámez
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Ocultar automáticamente el mensaje de error después de 5 segundos
window.addEventListener('DOMContentLoaded', () => {
    const errorDiv = document.getElementById('login-error');
    if(errorDiv){
        setTimeout(() => {
            errorDiv.style.transition = 'opacity 0.5s ease';
            errorDiv.style.opacity = '0';
        }, 5000);
    }

    // Validación en tiempo real
    const form = document.getElementById('loginForm');
    const submitBtn = document.getElementById('submitBtn');
    const userInput = document.getElementById('nomuser');
    const passInput = document.getElementById('passuser');

    form.addEventListener('input', () => {
        submitBtn.disabled = !(userInput.value.trim() && passInput.value.trim());
    });
});

// Mostrar / ocultar contraseña
function togglePassword() {
    const passInput = document.getElementById('passuser');
    if(passInput.type === "password"){
        passInput.type = "text";
    } else {
        passInput.type = "password";
    }
}
</script>
</body>
</html>
