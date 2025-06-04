<div class="container my-5 text-light">
  <h2 class="mb-4">Profilo Concessionaria</h2>
  <div class="mb-4 custom-bg-card p-4 rounded shadow-lg">
    <p><strong>Ragione Sociale:</strong> <?php echo htmlspecialchars($templateParams["concessionaria"]["ragSociale"]); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($templateParams["concessionaria"]["email"]); ?></p>
    <p><strong>Indirizzo:</strong> <?php echo htmlspecialchars($templateParams["concessionaria"]["sede"]); ?></p>
  </div>

  <h3 class="mb-3">Veicoli disponibili</h3>
  <div class="row">
    <?php if (count($templateParams["veicoli"]) > 0): ?>
      <?php foreach ($templateParams["veicoli"] as $veicolo): ?>
        <div class="col-md-4 col-lg-3 mb-4">
          <a href="vehicle.php?telaio=<?php echo urlencode($veicolo['numTelaio']); ?>" class="text-decoration-none">
            <div class="card card-hover custom-bg-card text-white h-100 shadow">
            <?php
                $nomeImmagine = strtolower(str_replace(' ', '', $veicolo['marca'] . $veicolo['modello'])) . ".jpeg";
                $percorsoImmagine = "style/vehicleImgs/" . $nomeImmagine;
              ?>
              
              <img src="<?php echo $percorsoImmagine; ?>" class="card-img-top" alt="<?php echo strtolower(str_replace(' ', '', $veicolo['marca'] . $veicolo['modello'])) . ".jpeg"; ?>">

              <div class="card-body d-flex flex-column">
                <h5 class="card-title">
                  <?php echo htmlspecialchars($veicolo['marca']) . " " . htmlspecialchars($veicolo['modello']); ?>
                </h5>
                <p class="card-text mb-1"><strong>Alimentazione:</strong> <?php echo htmlspecialchars($veicolo['alimentazione']); ?></p>
                <p class="card-text mb-1"><strong>Kilometri:</strong> <?php echo number_format($veicolo['kilometri']); ?></p>
                <p class="card-text mb-1"><strong>Prezzo:</strong> € <?php echo number_format($veicolo['prezzo'], 2); ?></p>
                <span class="badge <?php echo $veicolo['venduto'] ? 'bg-danger' : 'bg-success'; ?> mt-auto">
                  <?php echo $veicolo['venduto'] ? 'Venduto' : 'Disponibile'; ?>
                </span>
              </div>
            </div>
          </a>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p class="text-center">Nessun veicolo disponibile per questa concessionaria.</p>
    <?php endif; ?>
  </div>
</div>