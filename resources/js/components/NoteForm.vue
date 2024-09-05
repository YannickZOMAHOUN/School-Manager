<template>
    <div class="row col-12 pb-5">
        <div class="my-3">
            <h4 class="font-medium text-color-avt">Ajouter les notes</h4>
        </div>
        <div class="card py-5">
            <form @submit.prevent="submitForm">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-4 mb-3">
                            <label for="year" class="font-medium form-label fs-16 text-label">
                                Année Scolaire
                            </label>
                            <select class="form-select bg-form" v-model="selectedYear" @change="fetchClassrooms">
                                <option value="" disabled>Sélectionnez l'année scolaire</option>
                                <option v-for="year in years" :key="year.id" :value="year.id">
                                    {{ year.year }}
                                </option>
                            </select>
                        </div>
                        <div class="col-12 col-md-4 mb-3">
                            <label for="classroom" class="font-medium form-label fs-16 text-label">
                                Classe
                            </label>
                            <select class="form-select bg-form" v-model="selectedClassroom" @change="fetchStudents">
                                <option value="" disabled>Sélectionnez une classe</option>
                                <option v-for="classroom in classrooms" :key="classroom.id" :value="classroom.id">
                                    {{ classroom.classroom }}
                                </option>
                            </select>
                        </div>
                        <div class="col-12 col-md-4 mb-3">
                            <label for="student" class="font-medium form-label fs-16 text-label">
                                Élève
                            </label>
                            <select class="form-select bg-form" v-model="selectedStudent">
                                <option value="" disabled>Sélectionnez l'élève</option>
                                <option v-for="student in students" :key="student.id" :value="student.id">
                                    {{ student.name }} {{ student.surname }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-4 mb-3">
                            <label for="subject" class="font-medium form-label fs-16 text-label">
                                Matière
                            </label>
                            <select class="form-select bg-form" v-model="selectedSubject" @change="fetchRatio">
                                <option value="" disabled>Sélectionnez la matière</option>
                                <option v-for="subject in subjects" :key="subject.id" :value="subject.id">
                                    {{ subject.subject }}
                                </option>
                            </select>
                        </div>
                        <div class="col-12 col-md-4 mb-3">
                            <label for="ratio" class="font-medium form-label fs-16 text-label">
                                Coefficient
                            </label>
                            <input type="number" v-model="ratio" class="form-control bg-form" readonly>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 mb-3">
                        <label for="note" class="font-medium fs-16 text-black form-label">Moyenne non coefficiée</label>
                        <input type="number" v-model="note" class="form-control bg-form" placeholder="Entrez la note">
                    </div>
                    <div class="row d-flex justify-content-center mt-2">
                        <button type="reset" class="btn bg-secondary w-auto me-2 text-white" @click="resetForm">Annuler</button>
                        <button type="submit" class="btn btn-success w-auto">Enregistrer</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            years: [],
            classrooms: [],
            students: [],
            subjects: [],
            selectedYear: '',
            selectedClassroom: '',
            selectedStudent: '',
            selectedSubject: '',
            ratio: '',
            note: '',
        };
    },
    mounted() {
        this.fetchYears();
        this.fetchSubjects();
    },
    methods: {
        fetchYears() {
            axios.get('/api/years')
                .then(response => {
                    this.years = response.data;
                });
        },
        fetchClassrooms() {
            if (this.selectedYear) {
                axios.get(`/api/classrooms?year_id=${this.selectedYear}`)
                    .then(response => {
                        this.classrooms = response.data;
                    });
            }
        },
        fetchStudents() {
            if (this.selectedYear && this.selectedClassroom) {
                axios.get(`/api/students?year_id=${this.selectedYear}&classroom_id=${this.selectedClassroom}`)
                    .then(response => {
                        this.students = response.data;
                    });
            }
        },
        fetchSubjects() {
            axios.get('/api/subjects')
                .then(response => {
                    this.subjects = response.data;
                });
        },
        fetchRatio() {
            if (this.selectedSubject && this.selectedClassroom) {
                axios.get(`/api/ratio?subject_id=${this.selectedSubject}&classroom_id=${this.selectedClassroom}`)
                    .then(response => {
                        this.ratio = response.data.ratio;
                    });
            }
        },
        submitForm() {
            axios.post('/api/notes', {
                note: this.note,
                recording_id: this.selectedStudent,
                ratio_id: this.ratio,
                subject_id: this.selectedSubject,
            }).then(response => {
                alert('Note ajoutée avec succès');
                this.resetForm();
            });
        },
        resetForm() {
            this.selectedYear = '';
            this.selectedClassroom = '';
            this.selectedStudent = '';
            this.selectedSubject = '';
            this.ratio = '';
            this.note = '';
        }
    }
}
</script>

<style scoped>
/* Ajoutez vos styles ici */
</style>
