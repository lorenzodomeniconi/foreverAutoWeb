<?php
$ruolo = isset($_GET['ruolo']) ? $_GET['ruolo'] : null;
?>

<div class="bg-dark min-vh-100 d-flex align-items-center justify-content-center">
  <div class="card p-4 shadow-lg border-0" style="max-width: 400px; width: 100%; background-color: #1a1a1a; color: white; border-radius: 1rem;">

    <div class="text-center mb-4">
      <h2 class="mt-3">Registrazione</h2>
    </div>

    <?php if(isset($templateParams["erroresignup"])): ?>
      <div class="alert alert-warning text-center py-2">
        <?php echo $templateParams["erroresignup"]; ?>
      </div>
    <?php endif; ?>

    <?php if ($ruolo === 'acquirente'): ?>
      <!-- FORM ACQUIRENTE -->
      <form action="signup.php" method="POST">
        <div class="mb-3">
          <label for="codFiscale" class="form-label">Codice Fiscale</label>
          <input type="text" class="form-control bg-dark text-white border-secondary" id="codFiscale" name="codFiscale" placeholder="RSSMRA85M01H501Z" pattern="^[A-Z0-9]{16}$" maxlength="16" minlength="16" required
          title="Il Codice fiscale deve contenere esattamente 16 caratteri maiuscoli e numeri">
        </div>

        <div class="mb-3">
          <label for="nome" class="form-label">Nome</label>
          <input type="text" class="form-control bg-dark text-white border-secondary" id="nome" name="nome" placeholder="Mario" required>
        </div>

        <div class="mb-3">
          <label for="cognome" class="form-label">Cognome</label>
          <input type="text" class="form-control bg-dark text-white border-secondary" id="cognome" name="cognome" placeholder="Rossi" required>
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">E-mail</label>
          <input type="text" class="form-control bg-dark text-white border-secondary" id="email" name="email" placeholder="mario.rossi@gmail.com" required>
        </div>

        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" class="form-control bg-dark text-white border-secondary" id="username" name="username" required pattern="^\S+$" title="L'username non può contenere spazi" required>
        </div>

        <div class="mb-4">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control bg-dark text-white border-secondary" id="password" name="password" required>
        </div>

        <div class="d-flex justify-content-between">
          <a href="signup.php" class="btn btn-outline-light">Indietro</a>
          <button type="submit" class="btn btn-primary">Registrati</button>
        </div>
      </form>

    <?php elseif ($ruolo === 'concessionaria'): ?>
      <!-- FORM CONCESSIONARIA -->
      <form action="signup.php" method="POST">
        <div class="mb-3">
          <label for="partitaIva" class="form-label">Partita Iva</label>
          <input type="text" class="form-control bg-dark text-white border-secondary" id="partitaIva" name="partitaIva" placeholder="12345678901" pattern="^\d{11}$" maxlength="11" minlength="11" required
          title="La Partita IVA deve contenere esattamente 11 cifre">
        </div>
      
        <div class="mb-3">
          <label for="ragSociale" class="form-label">Ragione Sociale</label>
          <input type="text" class="form-control bg-dark text-white border-secondary" id="ragSociale" name="ragSociale" placeholder="ForeverAuto S.r.l.s." required>
        </div>

        <div class="mb-3">
          <label for="sede" class="form-label">Sede</label>
          <input type="text" class="form-control bg-dark text-white border-secondary" id="sede" name="sede" placeholder="Via dell'Università 50, Cesena" required>
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">E-mail</label>
          <input type="text" class="form-control bg-dark text-white border-secondary" id="email" name="email" placeholder="info@foreverauto.com" required>
        </div>

        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" class="form-control bg-dark text-white border-secondary" id="username" name="username" required pattern="^\S+$" title="L'username non può contenere spazi" required>
        </div>

        <div class="mb-4">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control bg-dark text-white border-secondary" id="password" name="password" required>
        </div>

        <div class="d-flex justify-content-between">
          <a href="signup.php" class="btn btn-outline-light">Indietro</a>
          <button type="submit" class="btn btn-primary">Registrati</button>
        </div>
      </form>

    <?php else: ?>
        <div class="text-center">
            <p class="mb-4">Scegli come vuoi registrarti:</p>
            <div class="row">
                <div class="col-6 pe-1">
                    <a href="signup.php?ruolo=acquirente" class="btn btn-outline-light w-100">Utente</a>
                </div>
                <div class="col-6 ps-1">
                    <a href="signup.php?ruolo=concessionaria" class="btn btn-outline-light w-100">Concessionaria</a>
                </div>
            </div>
        </div>

    <?php endif; ?>

  </div>
</div>