<script>
    let accionConfirmada = null;

    function mostrarModal(mensaje, urlDestino) {
        document.getElementById('modalMensaje').textContent = mensaje;
        accionConfirmada = urlDestino;
        document.getElementById('modalConfirm').classList.add('active');
    }

    function cerrarModal() {
        document.getElementById('modalConfirm').classList.remove('active');
        accionConfirmada = null;
    }

    function confirmarAccion() {
        if (accionConfirmada) {
            window.location.href = accionConfirmada;
        }
    }
</script>

<div id="modalConfirm" class="modal-overlay" onclick="if(event.target == this) cerrarModal()">
    <div class="container">
        <div class="alert info">
            <p id="modalMensaje"></p>
        </div>
        <div class="modal-buttons">
            <button onclick="confirmarAccion()">Sí, eliminar</button>
            <button onclick="cerrarModal()" style="background: #999;">Cancelar</button>
        </div>
    </div>
</div>
