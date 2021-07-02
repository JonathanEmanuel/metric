const app = new Vue({
    el: '#app',
    data: {
        anio: 0,
        mes: {
            Id: 0,
            Mes: ''
        },
        meses: [],
        anios: [],
        categoria: {
            CategoriaId: 0,
            TipoId: 1,
            Descripcion: ''
        },
        categorias: [],
        tipoId: 1,
        tipos: [],
        movimiento: {
            MovimientoId: 0,
            Concepto: '',
            CategoriaId: 0,
            TipoId: 0,
            FechaPlanificado: '',
            ValorPlanificado: '',
            FechaReal: '',
            ValorReal: '',
        },
        movimientos: [],
        resumenMes: {
            Ingresos: 0,
            Gastos: 0,
            Ahorros: 0
        },
        graficoPorciones: null,
        graficoValores: null

    },
    // Ejecucion despues que se renderiza la vista
    mounted: function(){
    },
    created: function() {
        this.config();
        this.tiposListar();
        this.movimientoListar();
        this.resumen();
    },
    computed: {
        movimientoSumatoria: function(){
            let valor = 0;
            this.movimientos.forEach(movimiento => {
                valor = valor + parseFloat( movimiento.ValorPlanificado )
            });
            n = valor.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
            n = n.split('').reverse().join('').replace(/^[\.]/,'');
            return n;
        },
        valorDisponible: function(){
            let resto = this.resumenMes.Ingresos - this.resumenMes.Gastos;
            n = resto.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
            n = n.split('').reverse().join('').replace(/^[\.]/,'');
            return n
        },
        valorIngresos: function() {
            n = this.resumenMes.Ingresos.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
            n = n.split('').reverse().join('').replace(/^[\.]/,'');
            return n
        },
        valorGastos: function() {
            n = this.resumenMes.Gastos.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
            n = n.split('').reverse().join('').replace(/^[\.]/,'');
            return n
        },
        valorAhorros: function() {
            n = this.resumenMes.Ahorros.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
            n = n.split('').reverse().join('').replace(/^[\.]/,'');
            return n
        }
    },
    methods: {
        config: function(){
            this.meses = [
                { Id: 1, Mes: 'Enero' },
                { Id: 2, Mes: 'Febrero' },
                { Id: 3, Mes: 'Marzo' },
                { Id: 4, Mes: 'Abril' },
                { Id: 5, Mes: 'Mayo' },
                { Id: 6, Mes: 'Junio' },
                { Id: 7, Mes: 'Julio' },
                { Id: 8, Mes: 'Agosto' },
                { Id: 9, Mes: 'Septiembre' },
                { Id: 10, Mes: 'Octubre' },
                { Id: 11, Mes: 'Noviembre' },
                { Id: 12, Mes: 'Diciembre' }
            ];
            
            let hoy = new Date();
            this.mes.Id = parseInt(hoy.getMonth()) + 1;
            this.mes.Mes = this.meses[this.mes.Id -1 ].Mes;
            this.anio = hoy.getFullYear();
            for (let i = 2019; i <= this.anio + 1; i++) {
                this.anios.push(i);
            }

            if( localStorage.getItem('tipoId')  ){
                try {
                    this.tipoId = JSON.parse(localStorage.getItem('tipoId'));
                } catch (error) {
                    localStorage.removeItem('tipoId');
                }
            }
        },
        actualizarFecha: function(){
            this.mes.Mes = this.meses[this.mes.Id -1 ].Mes;
            this.movimientoListar();
            this.resumen();
        },
        modalMovimientoAbrir: function(){
            this.movimiento.MovimientoId = 0;
            this.movimiento.Concepto = '';
            this.movimiento.CategoriaId = 0;
            this.movimiento.TipoId = 0;
            this.movimiento.FechaPlanificado = '';
            this.movimiento.ValorPlanificado = '';
            this.movimiento.FechaReal = '';
            this.movimiento.ValorReal = '';
            $('#modalMovimiento').modal('show');
        },
        modalCategoriaAbrir: function(){
            this.categoria.CategoriaId = 0;
            this.categoria.TipoId = 0;
            this.categoria.Descripcion = '';
            $('#modalCategoria').modal('show');
        },
        tiposListar: function(){
            this.tipos = []; 
            axios.get('./movimientoTipo/listar', {})
            .then(function (response) {
                let respuesta = response.data;
                if ( respuesta.error != 'N'){
                    alert('ERROR, No se pudo completar la operación');
                    return;
                }
                respuesta.datos.forEach(tipo => {
                    app.tipos.push({
                        TipoId: tipo.TipoId,
                        Descripcion: tipo.Descripcion
                    })
                });
            })
            .catch(function (error) {
                console.error(error);
            }).then(function () {
                // always executed
            });
        },
        categoriasListar: function(){
            this.categorias = [];
            this.movimiento.CategoriaId = 0;
            axios.post('/categoria/listar', {TipoId: this.movimiento.TipoId})
            .then(function (response) {
                let respuesta = response.data;
                if ( respuesta.error != 'N'){
                    alert('ERROR, No se pudo completar la operación');
                    return;
                }
                respuesta.datos.forEach(categoria => {
                    app.categorias.push({
                        CategoriaId: categoria.CategoriaId,
                        TipoId: categoria.TipoId,
                        Descripcion: categoria.Descripcion
                    })
                });
            })
            .catch(function (error) {
                console.error(error);
            }).then(function () {
                // always executed
            });
        },
        categoriaGuardar: function(){
            if( this.categoria.Descripcion == ''){
                alert('Por favor, complete la Descripción');
                return;
            }

            let parametros = {
                CategoriaId: this.categoria.CategoriaId,
                TipoId: this.categoria.TipoId,
                Descripcion: this.categoria.Descripcion
            }

            axios.post('/categoria/guardar', parametros)
            .then(function (response) {
                const respuesta = response.data;
                if ( respuesta.error != 'N'){
                    alert('ERROR, No se pudo completar la operación');
                    return;
                }
                $('#modalCategoria').modal('hide');
            })
            .catch(function (error) {
                console.error(error);
            }).then(function () {
                app.categoriasListar();
            });
        },
        movimientoListar: function(){
            this.movimientos = [];
            let porciones = [];
            let index = 0;
            let total = 0;
            let parametros = {
                TipoId: this.tipoId,
                Mes: this.mes.Id,
                Anio: this.anio
            }
            localStorage.setItem('tipoId', this.tipoId);

            axios.post('./movimiento/listar', parametros)
            .then(function (response) {
                let respuesta = response.data;
                if ( respuesta.error != 'N'){
                    alert('ERROR, No se pudo completar la operación');
                    return;
                }
                respuesta.datos.forEach(movimiento => {
                    app.movimientos.push({
                        MovimientoId: movimiento.MovimientoId,
                        Descripcion: movimiento.Descripcion,
                        FechaPlanificado: movimiento.FechaPlanificado,
                        ValorPlanificado: movimiento.ValorPlanificado,
                        FechaReal: movimiento.FechaReal,
                        ValorReal: movimiento.ValorReal,
                        TipoId: movimiento.Tipoid,
                        CategoriaId: movimiento.CategoriaId,
                        Categoria: movimiento.Categoria,
                        Confirmado: movimiento.FechaReal == null ? false : true
                    })

                    total = total + parseFloat(movimiento.ValorPlanificado);

                    index =  porciones.findIndex( (registro) =>  registro.CategoriaId === parseInt(movimiento.CategoriaId)   );
                    if ( index != -1 ) {
                        //console.log('E', index)
                        porciones[index].Cantidad = porciones[index].Cantidad + 1;
                        porciones[index].Valor = porciones[index].Valor + parseFloat(movimiento.ValorPlanificado);

                    } else {
                        //console.log('N', index)
                        porciones.push({
                            CategoriaId: parseInt(movimiento.CategoriaId),
                            Descripcion: movimiento.Categoria,
                            Cantidad: 1,
                            Valor: parseFloat(movimiento.ValorPlanificado)
                        })
                    }
                });
            })
            .catch(function (error) {
                console.error(error);
            }).then(function () {
                console.table(porciones);
                if ( app.graficoPorciones == null){
                    app.graficoCategoriasGenerar(porciones, total);
                } else {
                    app.graficoCategoriasActualizar(porciones, total);
                }
 
                if ( app.graficoValores == null){
                    app.graficoValoresGenerar(porciones);
                } else {
                    app.graficoValoresActualizar(porciones);
                }
 
            });
        },
        movimientoGuardar: function(){
            let parametros = {
                MovimientoId: this.movimiento.MovimientoId,
                Descripcion: this.movimiento.Concepto,
                FechaPlanificado: this.movimiento.FechaPlanificado,
                ValorPlanificado: this.movimiento.ValorPlanificado,
                CategoriaId: this.movimiento.CategoriaId,
                TipoId: this.movimiento.TipoId
            }

            axios.post('/movimiento/guardar', parametros)
            .then(function (response) {
                const respuesta = response.data;
                if ( respuesta.error != 'N'){
                    alert('ERROR, No se pudo completar la operación');
                    return;
                }

                app.movimientoListar();
                $('#modalMovimiento').modal('hide');
            })
            .catch(function (error) {
                console.error(error);
            }).then(function () {
                app.resumen();
            });
        },
        movimientoAbrir: function(movimiento){
            console.log(movimiento);
            this.movimiento.MovimientoId = movimiento.MovimientoId;
            this.movimiento.Concepto = movimiento.Descripcion;
            this.movimiento.TipoId = movimiento.TipoId;
            this.categoriasListar();

            this.movimiento.FechaPlanificado = movimiento.FechaPlanificado;
            this.movimiento.ValorPlanificado = movimiento.ValorPlanificado;
            this.movimiento.CategoriaId = movimiento.CategoriaId

            this.movimiento.FechaReal = '';
            this.movimiento.ValorReal = '';
            $('#modalMovimiento').modal('show');
        },
        movimientoConfirmar: function(movimiento){
            movimiento.Confirmado = true;
            let parametros = {
                MovimientoId: movimiento.MovimientoId,
                ValorPlanificado: movimiento.ValorPlanificado
            }

            axios.post('/movimiento/marcarRealizado', parametros)
            .then(function (response) {
                let respuesta = response.data;
                if ( respuesta.error != 'N'){
                    console.error(respuesta.error);
                    alert('ERROR, No se pudo completar la operación');
                    return;
                }

                //console.log(respuesta.datos)               
            })
            .catch(function (error) {
                console.error(error);
            }).then(function () {
                // always executed
            });
        },
        resumen: function(){
            let parametros = {
                Mes: this.mes.Id,
                Anio: this.anio
            }
            axios.post('movimiento/totales', parametros)
            .then(function (response) {
                let respuesta = response.data;
                if ( respuesta.error != 'N'){
                    alert('ERROR, No se pudo completar la operación');
                    return;
                }
                let datos = respuesta.datos[0];
                app.resumenMes.Ingresos = datos.Ingresos != null ? parseInt(datos.Ingresos) : 0;
                app.resumenMes.Gastos = datos.Gastos != null ? parseInt(datos.Gastos) : 0;
                app.resumenMes.Ahorros = datos.Ahorros != null ? parseInt(datos.Ahorros) : 0;
            })
            .catch(function (error) {
                console.error(error);
            }).then(function () {
                // always executed
            });
        },
        graficoCategoriasGenerar: function(porciones, total){
            let dataSet = [];
            console.info('Generando Grafico Porciones', porciones);
            console.info(total);
            for (let index = 0; index < porciones.length; index++) {
                const categoria = porciones[index];
                console.log(categoria);
                const porcentaje = categoria.Valor * 100 / total;
                porciones[index].Porcentaje = porcentaje.toFixed(2);
            }


            console.table(porciones);
            for (let index = 0; index < porciones.length; index++) {
                const element = porciones[index];
                dataSet.push({
                    value: porciones[index].Porcentaje,
                    label: porciones[index].Descripcion
                })
                
            }

            this.graficoPorciones = new Morris.Donut({
                element: 'graficoPorciones',
                data: dataSet,
                formatter: function (x) { return x + "%"},
                
            }).on('click', function(i, row){
                console.log(i, row);
            });


        },
        graficoCategoriasActualizar: function(porciones, total){
            console.info('Generando Grafico Porciones', porciones, total);
            let setDatos = porciones;
            for (let index = 0; index < porciones.length; index++) {
                const categoria = porciones[index];
                //console.log(categoria);
                const porcentaje = categoria.Valor * 100 / total;
                porciones[index].Porcentaje =  porcentaje.toFixed(2);
            }
            for (let index = 0; index < porciones.length; index++) {
                const element = porciones[index];
                setDatos.push({
                    value: porciones[index].Porcentaje,
                    label: porciones[index].Descripcion
                })
                
            }
            this.graficoPorciones.setData(setDatos);
        },
        graficoValoresGenerar: function(porciones){
            console.log(porciones);
            let dataSet = porciones;
            console.info('Generando Grafico Valores', porciones);
  

            this.graficoValores = new Morris.Bar({
                element: 'graficoValores',
                data: dataSet,
                xkey: 'Descripcion',
                // A list of names of data record attributes that contain y-Valors.
                ykeys: ['Valor'],
                // Labels for the ykeys -- will be displayed when you hover over the
                // chart.
                labels: ['Descripcion']
                
            }).on('click', function(i, row){
                console.log(i, row);
            });


        },
        graficoValoresActualizar: function(porciones){
            console.info('Generando Valores Porciones', porciones);
            return;
            let setDatos = porciones;
            this.graficoValores.setData(setDatos);
        },
    }
})