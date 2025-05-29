<div class="container">
        <h2>Modifica il vehicle: <?php echo htmlspecialchars($templateParams['vehicle'][0]['marca'] . " " . $templateParams['vehicle'][0]['modello']); ?></h2>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
        <?php endif; ?>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($_GET['success']); ?></div>
        <?php endif; ?>

        <form action="updatedVehicle.php?numTelaio=<?php echo $templateParams['vehicle'][0]['numTelaio']; ?>" method="POST">
            <div class="mb-3">
                <label for="marca" class="form-label">Marca</label>
                <input type="text" class="form-control dark-input" id="marca" name="marca" value="<?php echo htmlspecialchars($templateParams['vehicle'][0]['marca']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="modello" class="form-label">Modello</label>
                <input type="text" class="form-control dark-input" id="modello" name="modello" value="<?php echo htmlspecialchars($templateParams['vehicle'][0]['modello']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="prezzo" class="form-label">Prezzo (€)</label>
                <input type="number" class="form-control dark-input" id="prezzo" name="prezzo" value="<?php echo htmlspecialchars($templateParams['vehicle'][0]['prezzo']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="descrizione" class="form-label">Descrizione</label>
                <textarea class="form-control dark-input" id="descrizione" name="descrizione" rows="3"><?php echo htmlspecialchars($templateParams['vehicle'][0]['descrizione']); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="proprietariPrecedenti" class="form-label">Proprietari Precedenti</label>
                <input type="number" class="form-control dark-input" id="proprietariPrecedenti" name="proprietariPrecedenti" value="<?php echo htmlspecialchars($templateParams['vehicle'][0]['proprietariPrecedenti']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="kilometri" class="form-label">Kilometri</label>
                <input type="number" class="form-control dark-input" id="kilometri" name="kilometri" value="<?php echo htmlspecialchars($templateParams['vehicle'][0]['kilometri']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="alimentazione" class="form-label">Alimentazione</label>
                <input type="text" class="form-control dark-input" id="alimentazione" name="alimentazione" value="<?php echo htmlspecialchars($templateParams['vehicle'][0]['alimentazione']); ?>" required>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="venduto" name="venduto" <?php echo $templateParams['vehicle'][0]['venduto'] ? 'checked' : ''; ?>>
                <label class="form-check-label" for="venduto">Venduto</label>
            </div>
            <button type="submit" class="btn btn-primary">Salva modifiche</button>
        </form>
    </div>