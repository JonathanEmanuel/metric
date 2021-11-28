let app = new Vue({
  el: "#app",
  data: {
    fechaInicio: "",
    fechaFinal: "",
    ingreso: "",
    egreso: "",
    total: "",
    url: "resumen/obtenerResumen",
  },
  methods: {
    obtenerResumen: function () {
      const params = {
        fechaInicio: this.fechaInicio,
        fechaFinal: this.fechaFinal,
      };
      console.log("lol", this.fechaFinal, this.fechaInicio);
      fetch(this.url, {
        method: "POST", // or 'PUT'
        body: JSON.stringify(params), // data can be `string` or {object}!
        headers: {
          "Content-Type": "application/json",
        },
      })
        .then((respuesta) => respuesta.json())
        .then((data) => {
          console.log(data);
          this.ingreso = data.datos[0];
          this.egreso = data.datos[1];
          this.total = data.datos[2];
        });
    },
  },
});
