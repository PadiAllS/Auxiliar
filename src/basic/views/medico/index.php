<?php
/* @var $this yii\web\View */

//$this->registerCssFile("https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css",['position'=>$this::POS_HEAD]);
$this->registerJsFile("https://cdn.jsdelivr.net/npm/vue/dist/vue.js",['position'=>$this::POS_HEAD]);
$this->registerJsFile("https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js",['position'=>$this::POS_HEAD]);

?>

<div id="app" class="container">
    <h1>{{msg}}</h1>
    <!-- Button trigger modal -->
    <div>
        <div class="col-6 m-auto pb-3">
            <form action="">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input v-model="medico.nombre" type="text" name="nombre" id="nombre" class="form-control" placeholder="Ingrese especialidad" aria-describedby="helpId">
                    <small id="titlehelpId" class="text-muted"></small>
                </div>
                <div class="form-group">
                    <label for="detalle">Apellido</label>
                    <input v-model="medico.apellido" type="text" name="apellido" id="apellido" class="form-control" placeholder="Ingrese apellido" aria-describedby="helpId">
                    <small id="bodyhelpId" class="text-muted"></small>
                    <span></span>
                </div>
                <div class="form-group">
                    <label for="detalle">Especialidad</label>
                    <select class="form-control" v-model="medico.especialidad_id">
                        <option :value="espe.id_especialidad" v-for="espe in options">
                            {{espe.nombre}}
                        </option>
                    </select>
                    <small id="bodyhelpId" class="text-muted"></small>
                    <span></span>
                </div>

                <button v-if="isNewRecord"  @click="addEspecialidad()" type="button" class="btn btn-primary m-3">Crear</button>
                <button v-if="!isNewRecord"  @click="especialidad={}" type="button" class="btn btn-success m-3">Nuevo</button>
                <button v-if="!isNewRecord" @click="updateEspecialidad(especialidad.id_especialidad)" type="button" class="btn btn-primary m-3">Actualizar</button>
            </form>
        </div>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(medico,key) in medicos" v-bind:key="medico.id_medico">
            <td scope="row">{{medico.id_medico}}</td>
            <td>{{medico.nombre}}</td>
            <td>{{medico.apellido}}</td>
            <td>
               <div v-if="medico.especialidad"> {{medico.especialidad.nombre}}</div>
            </td>

            <td>
                <button v-on:click="editEspecialidad(key)" type="button" class="btn btn-warning">Editar</button>
            </td>
            <td>
                <button v-on:click="deleteEspecialidad(espec.id_especialidad)" type="button" class="btn btn-danger">Borrar</button>
            </td>
        </tr>
        </tbody>
    </table>

</div>

<script>

    var app = new Vue({

        el: "#app",
        data: function () {
            return {
                msg: "Medicos",
                especialidades: [],
                especialidad:{},
                isNewRecord:true,
                medicos:[],
                medico:{},
                options:[],
            }
        },
        mounted() {
            this.getEspecialidades();
            this.getOptions();
        },
        methods: {

            getOptions(){
                var self = this;
                axios.get('/apiv1/especialidads')
                    .then(function (response) {
                        // handle success
                        console.log(response.data);
                        console.log("trage todas las especialidades");
                        // self.especialidades = response.data;
                        self.options = response.data;
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    })
                    .then(function () {
                        // always executed
                    });
            },
            getEspecialidades: function(){
                var self = this;
                axios.get('/apiv1/medicos')
                    .then(function (response) {
                        // handle success
                        console.log(response.data);
                        console.log("trage todas las especialidades");
                        // self.especialidades = response.data;
                        self.medicos = response.data;
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    })
                    .then(function () {
                        // always executed
                    });
            },
            deleteEspecialidad: function(id){
                var self = this;
                axios.delete('/apiv1/medicos/'+ id)
                    .then(function (response) {
                        // handle success
                        console.log("borra especialidad id: "+ id);
                        console.log(response.data);
                        self.getEspecialidades();
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    })
                    .then(function () {
                        // always executed
                    });
            },
            editEspecialidad: function (key) {
                this.especialidad = Object.assign({},this.especialidades[key]);
                this.especialidad.key = key;
                this.isNewRecord = false;
            },
            addEspecialidad: function(){
                var self = this;
                axios.post('/apiv1/medicos',self.medico)
                    .then(function (response) {
                        // handle success
                        console.log(response.data);
                        self.getEspecialidades()
                        // self.posts.unshift(response.data);
                        self.medico = {};
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);

                    })
                    .then(function () {
                        // always executed
                    });
            },
            updateEspecialidad: function (key) {
                var self = this;
                const params = new URLSearchParams();
                params.append('nombre', self.especialidad.nombre);
                params.append('detalle', self.especialidad.detalle);
                axios.patch('/apiv1/medicos/'+key,self.medico)
                    .then(function (response) {
                        // handle success
                        console.log(response.data);
                        self.getEspecialidades();
                        self.medico = {};
                        self.isNewRecord = true;
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    })
                    .then(function () {
                        // always executed
                    });

            }

        }

    })

</script>
