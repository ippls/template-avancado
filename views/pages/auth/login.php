<div class="container">
  <!-- LEFT -->
  <div class="left-side">
    <div class="form-wrapper">
      <div class="card">
        
        <!-- HEADER -->
        <div class="header">
          <div class="icon-circle">
            <i class="fas fa-sign-in-alt"></i>
          </div>
          <h2 class="title">Bem vindo de volta!</h2>
          <p class="subtitle">Faça login para continuar.</p>
        </div>

        <!-- FORM -->
        <form class="form" method="POST" action="<?= url('/auth/login') ?>">
          <?= csrfField() ?>

          <!-- EMAIL -->
          <div class="form-group">
            <label class="label" for="email">Endereço de email</label>
            <div class="input-wrapper">
              <input
                type="email"
                id="email"
                name="email"
                class="input"
                placeholder="ngola@exemplo.com"
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
                onclick="togglePassword()"
              >
                <i class="fas fa-eye" id="eye-icon"></i>
              </button>
            </div>
          </div>

          <!-- BUTTON -->
          <button type="submit" class="btn">
            Entrar
          </button>

          <!-- FOOTER -->
          <div class="footer">
            Não tem uma conta?
            <a href="<?= url('/register') ?>">Inscrever-se</a>
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
        <h2 class="overlay-title">Bem-vindo de volta - IPPLS</h2>
        <p class="overlay-text">
          Acesse sua conta e continue desenvolvendo projetos 
          profissionais com a arquitetura MVC mais completa do mercado do desenvolvimento.
        </p>
      </div>
    </div>
  </div>
</div>

<script>
  function togglePassword() {
    const input = document.getElementById('password');
    const icon = document.getElementById('eye-icon');
    
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