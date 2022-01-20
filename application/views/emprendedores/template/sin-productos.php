<div class="row justify-content-md-center">
    <div class="col-md-8 py-4">
        <!-- No tienes pedidos -->
        <div class="alert alert-danger text-center" role="alert">
            <h4 class="alert-heading">Oops! 🙈</h4>
            <p>Aún no tienes productos en el carrito.</p>
            <img class="img-fluid" src="https://media.giphy.com/media/YSeRKAa0JJjTJxbD0R/giphy-downsized.gif">
            <hr>
            <p class="mb-1">Apoya a los emprendedores de tu ciudad</p>
            <a href="<?= $this->session->userdata('back_url') ?>" class="btn btn-primary"><i class="fas fa-store-alt"></i>&nbsp; Regresa a la tienda</a>
        </div>
    </div>
</div>