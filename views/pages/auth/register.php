<div class="container">
  <!-- LEFT -->
  <div class="left-side">
    <div class="form-wrapper">
      <div class="card">
        
        <!-- HEADER -->
        <div class="header">
          <div class="icon-circle">
            <i class="fas fa-user-plus"></i>
          </div>
          <h2 class="title">Criar uma conta</h2>
          <p class="subtitle">Comece a usar sua conta.</p>
        </div>

        <!-- FORM -->
        <form class="form" method="POST" action="<?= url('/auth/register') ?>">
          <?= csrfField() ?>

          <!-- NOME -->
          <div class="form-group">
            <label class="label" for="name">Nome completo</label>
            <div class="input-wrapper">
              <input
                type="text"
                id="name"
                name="name"
                class="input"
                placeholder="Pai Grande Ngola"
                required
              />
            </div>
          </div>

          <!-- EMAIL -->
          <div class="form-group">
            <label class="label" for="email">Endereço de email</label>
            <div class="input-wrapper">
              <input
                type="email"
                id="email"
                name="email"
                class="input"
                placeholder="você@exemplo.com"
                required
              />
              <i class="fas fa-envelope input-icon"></i>
            </div>
          </div>

          <!-- SENHA -->
          <div class="form-group">
            <label class="label" for="password">Senha</label>
            <div class="input-wrapper">
              <input
                type="password"
                id="password"
                name="password"
                class="input"
                placeholder="•••••••"
                required
              />
              <button
                type="button"
                class="toggle-password"
                onclick="togglePassword('password', 'eye-icon-1')"
              >
                <i class="fas fa-eye" id="eye-icon-1"></i>
              </button>
            </div>
          </div>

          <!-- CONFIRMAR SENHA -->
          <div class="form-group">
            <label class="label" for="confirmPassword">Confirme sua senha</label>
            <div class="input-wrapper">
              <input
                type="password"
                id="confirmPassword"
                name="confirmPassword"
                class="input"
                placeholder="•••••••"
                required
              />
              <button
                type="button"
                class="toggle-password"
                onclick="togglePassword('confirmPassword', 'eye-icon-2')"
              >
                <i class="fas fa-eye" id="eye-icon-2"></i>
              </button>
            </div>
          </div>

          <!-- BUTTON -->
          <button type="submit" class="btn">
            Criar uma conta
          </button>

          <!-- FOOTER -->
          <div class="footer">
            Já tem uma conta?
            <a href="<?= url('/login') ?>">Entrar</a>
          </div>

        </form>
      </div>
    </div>
  </div>

<!-- RIGHT -->
<div class="right-side" 
style="
    background: url('<?= asset('images/screen-split-auth-image.jpg') ?>');
    background-size: cover;
    background-position: center;
    ">
    <div class="overlay">
      <div class="overlay-content">
      <a href="<?= url('/') ?>"><img src="
          <?= asset('images/logo/ippls-logo-removebg-preview.png') ?>" alt="IPPLS" class="logo-img">
      </a>
        <h2 class="overlay-title">Comece sua Jornada.</h2>
        <p class="overlay-text">
          Crie sua conta e comece a desenvolver aplicações web profissionais com a melhor arquitetura MVC pensada para estudantes e desenvolvedores!
        </p>
      </div>
    </div>
  </div>
</div>

<script>
  function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    
    if (input.type === 'password') {
      input.type = 'text';
      icon.classList.remove('fa-eye');
      icon.classList.add('fa-eye-slash');
    } else {
      input.type = 'password';
      icon.classList.remove('fa-eye-slash');
      icon.classList.add('fa-eye');
    }
  }
</script>