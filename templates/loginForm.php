<div class="bg-dark min-vh-100 d-flex align-items-center justify-content-center">
  <div class="card p-4 shadow-lg border-0" style="max-width: 400px; width: 100%; background-color: #1a1a1a; color: white; border-radius: 1rem;">
    
    <div class="text-center mb-4">
      <img src="style/forever.png" alt="foreverAutoLogo" class="img-fluid" style="max-height: 80px;">
      <h2 class="mt-3">Accedi</h2>
    </div>

    <?php if(isset($templateParams["error"])): ?>
      <div class="alert alert-warning text-center py-2">
        <?php echo $templateParams["error"]; ?>
      </div>
    <?php endif; ?>

    <form action="#" method="POST">
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control bg-dark text-white border-secondary" id="username" name="username" required>
      </div>

      <div class="mb-4">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control bg-dark text-white border-secondary" id="password" name="password" required>
      </div>

      <div class="d-grid">
        <button type="submit" class="btn btn-primary">Login</button>
      </div>
    </form>
  </div>
</div>