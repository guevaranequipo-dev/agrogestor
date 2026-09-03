import { createApp } from 'vue'
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap.bundle.min.js'

// Componentes Vue
import FormularioPago from './components/FormularioPago.vue'
import TablaFiltrable from './components/TablaFiltrable.vue'

const app = createApp({})

app.component('formulario-pago', FormularioPago)
app.component('tabla-filtrable', TablaFiltrable)

app.mount('#app')
