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
        movimientos: [],
        grafico: null,

    },
    created: function() {
        this.config();
        this.ingresosSalidasAnio();
    },
    methods: {
        config: function(){
            this.meses = [
                { Id: 1,  Mes: 'Enero',      Ingresos: 0, Gastos: 0 },
                { Id: 2,  Mes: 'Febrero',    Ingresos: 0, Gastos: 0 },
                { Id: 3,  Mes: 'Marzo',      Ingresos: 0, Gastos: 0 },
                { Id: 4,  Mes: 'Abril',      Ingresos: 0, Gastos: 0 },
                { Id: 5,  Mes: 'Mayo',       Ingresos: 0, Gastos: 0 },
                { Id: 6,  Mes: 'Junio',      Ingresos: 0, Gastos: 0 },
                { Id: 7,  Mes: 'Julio',      Ingresos: 0, Gastos: 0 },
                { Id: 8,  Mes: 'Agosto',     Ingresos: 0, Gastos: 0 },
                { Id: 9,  Mes: 'Septiembre', Ingresos: 0, Gastos: 0 },
                { Id: 10, Mes: 'Octubre',    Ingresos: 0, Gastos: 0 },
                { Id: 11, Mes: 'Noviembre',  Ingresos: 0, Gastos: 0 },
                { Id: 12, Mes: 'Diciembre',  Ingresos: 0, Gastos: 0 }
            ];
            
            let hoy = new Date();
            this.mes.Id = parseInt(hoy.getMonth()) + 1;
            this.mes.Mes = this.meses[this.mes.Id -1 ].Mes;
            this.anio = hoy.getFullYear();
            for (let i = 2019; i <= this.anio + 1; i++) {
                this.anios.push(i);
            }
        },
        ingresosSalidasAnio: function(){
            let parametros = {
                Anio: this.anio
            }
            axios.post('movimiento/ingresosSalidasAnio', parametros)
            .then(function (response) {
                let respuesta = response.data;
                if ( respuesta.error != 'N'){
                    alert('ERROR, No se pudo completar la operación');
                    return;
                }
                let datos = respuesta.datos;
                let movimientos;
                console.table(datos);
                if( datos.length > 0){
                    app.meses.forEach(mes => {
                        console.log(mes.Id, mes.Mes);
                        mes.Ingresos = 0;
                        mes.Gastos = 0;
                        movimientos = datos.filter(registro => registro.Mes == mes.Id);
                        console.log(movimientos);
                        if( movimientos.length > 0){
                            mes.Ingresos = movimientos[0].Ingresos;
                            mes.Gastos = movimientos[0].Gastos;

                        }
                    });
                } else {
                    app.grafico.setData([]);

                }

            })
            .catch(function (error) {
                console.log(error);
            }).then(function () {
                if ( app.grafico == null){
                    app.generarGrafico();
                } else {
                    app.graficoActualizar();
                }
            });
        },
        // Genera Grafico 
        generarGrafico: function(){
            this.grafico = new Morris.Bar({
                element: 'graficoSalidasIngresos',
                data: this.meses,
                xkey: 'Mes',
                ykeys: ['Ingresos', 'Gastos'],
                labels: ['Ingresos', 'Gastos'],
                barRatio: 0.4,
                xLabelAngle: 35,
                //barColors: ['#337ab7'],
                hideHover: 'auto',
                resize: true
            });
        },
        graficoActualizar: function(){
            let setDatos = this.meses;
            console.log(setDatos);
            this.grafico.setData(setDatos);
        },
    }
})