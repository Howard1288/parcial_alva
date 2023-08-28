import Chart from "chart.js/auto";
import { Toast } from "../funciones";

const canvasUsuariosPorRol = document.getElementById('chartUsuariosPorRol');
const contextUsuariosPorRol = canvasUsuariosPorRol.getContext('2d');

const getRandomColor = () => {
    const r = Math.floor(Math.random() * 256);
    const g = Math.floor(Math.random() * 256);
    const b = Math.floor(Math.random() * 256);

    const rgbColor = `rgba(${r},${g},${b},0.7)`;
    return rgbColor;
};

const chartUsuariosPorRol = new Chart(contextUsuariosPorRol, {
    type: 'bar',
    data: {
        labels: [],
        datasets: [
            {
                label: 'Usuarios por Rol',
                data: [],
                backgroundColor: []
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Distribución de Usuarios por Rol'
            }
        }
    }
});

const getEstadisticasUsuariosPorRol = async () => {
    const url = `/parcial_alva/API/usuario/estadistica`;
    const config = {
        method: 'GET'
    };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        console.log(data);

        const usuariosPorRol = {};

        if (data) {
            data.forEach(registro => {
                const rol = registro.usu_rol;
                if (usuariosPorRol[rol]) {
                    usuariosPorRol[rol]++;
                } else {
                    usuariosPorRol[rol] = 1;
                }
            });

            const labels = Object.keys(usuariosPorRol);
            const dataCounts = Object.values(usuariosPorRol);

            chartUsuariosPorRol.data.labels = labels;
            chartUsuariosPorRol.data.datasets[0].data = dataCounts;
            chartUsuariosPorRol.data.datasets[0].backgroundColor = labels.map(() => getRandomColor());

            chartUsuariosPorRol.options.plugins.title.text = `Usuarios por Rol - Total: ${data.length} Usuarios`;
        } else {
            Toast.fire({
                title: 'No se encontraron registros',
                icon: 'info'
            });

            chartUsuariosPorRol.options.plugins.title.text = 'Distribución de Usuarios por Rol';
        }

        chartUsuariosPorRol.update();
    } catch (error) {
        console.log(error);
    }
};

getEstadisticasUsuariosPorRol();

const canvasUsuariosPorSituacion = document.getElementById('chartUsuariosPorSituacion');
const contextUsuariosPorSituacion = canvasUsuariosPorSituacion.getContext('2d');

const chartUsuariosPorSituacion = new Chart(contextUsuariosPorSituacion, {
    type: 'pie',
    data: {
        labels: [],
        datasets: [
            {
                label: 'Usuarios por Situación',
                data: [],
                backgroundColor: []
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Distribución de Usuarios por Situación'
            }
        }
    }
});

const getEstadisticasUsuariosPorSituacion = async () => {
    const url = `/parcial_alva/API/usuario/estadistica`;
    const config = {
        method: 'GET'
    };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        console.log(data);

        const usuariosPorSituacion = {};

        if (data) {
            data.forEach(registro => {
                const situacion = registro.usu_situacion;
                if (usuariosPorSituacion[situacion]) {
                    usuariosPorSituacion[situacion]++;
                } else {
                    usuariosPorSituacion[situacion] = 1;
                }
            });

            const labels = Object.keys(usuariosPorSituacion);
            const dataCounts = Object.values(usuariosPorSituacion);

            chartUsuariosPorSituacion.data.labels = labels;
            chartUsuariosPorSituacion.data.datasets[0].data = dataCounts;
            chartUsuariosPorSituacion.data.datasets[0].backgroundColor = labels.map(() => getRandomColor());

            chartUsuariosPorSituacion.options.plugins.title.text = `Usuarios por Situación - Total: ${data.length} Usuarios`;
        } else {
            Toast.fire({
                title: 'No se encontraron registros',
                icon: 'info'
            });

            chartUsuariosPorSituacion.options.plugins.title.text = 'Distribución de Usuarios por Situación';
        }

        chartUsuariosPorSituacion.update();
    } catch (error) {
        console.log(error);
    }
};

getEstadisticasUsuariosPorSituacion();