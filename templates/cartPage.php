<div class="container my-5">
    <h2>Il tuo Carrello</h2>
    <?php if (count($templateParams["vehicles"]) > 0): ?>
        <?php 
            $totale = 0; 
            $vehiclesDisponibili = 0;
        ?>
        <div class="row">
            <?php foreach ($templateParams["vehicles"] as $veicolo): ?>
                <?php 
                    if (!$veicolo['venduto']) {
                        $totale += $veicolo['prezzo']; 
                        $vehiclesDisponibili++;
                    }
                ?>
                <div class="col-md-4">
                    <div class="card custom-bg-card mb-4">
                        <?php
                            $nomeImmagine = strtolower(str_replace(' ', '', $veicolo['marca'] . $veicolo['modello'])) . ".jpeg";
                            $percorsoImmagine = "style/vehicleImgs/" . $nomeImmagine;
                        ?>
                        <img src="<?php echo $percorsoImmagine; ?>" class="card-img-top" alt="<?php echo $nomeImmagine; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($veicolo['marca'] . " " . $veicolo['modello']); ?></h5>
                            <p class="card-text">Prezzo: € <?php echo number_format($veicolo['prezzo'], 2); ?></p>
                            <?php if ($veicolo['venduto']): ?>
                                <p class="text-danger">Questo veicolo è stato venduto</p>
                            <?php else: ?>
                                <form action="deleteFromCart.php" method="POST">
                                    <input type="hidden" name="numTelaio" value="<?php echo htmlspecialchars($veicolo['numTelaio']); ?>">
                                    <button type="submit" class="btn btn-danger">Rimuovi dal carrello</button>
                                </form>

                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="text-end text-light mt-4">
            <h4>Totale: € <?php echo number_format($totale, 2); ?></h4>
        </div>

        <?php if ($vehiclesDisponibili > 0): ?>
            <div class="text-end mt-3">
                <a href="payment.php" class="btn btn-primary">Procedi al pagamento</a>
            </div>
        <?php endif; ?>

    <?php else: ?>
        <p>Il tuo carrello è vuoto.</p>
    <?php endif; ?>
</div>