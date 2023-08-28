import Chart from "chart.js/auto"; 
import { Toast } from "../funciones"; 
 
const canvas = document.getElementById('chartRoles') 
const btnActualizar = document.getElementById('btnActualizar') 
const context = canvas.getContext('2d'); 
 
 
const chartClientes = new Chart(context, { 
    type : 'bar', 
    data : { 
        labels : [], 
        datasets : [ 
            { 
                label : 'Roles', 
                data : [], 
                backgroundColor : [] 
            }, 
        ] 
    }, 
    options : { 
        indexAxis : 'x' 
    } 
}) 
 
const getEstadisticas = async () => { 
    const url = `/parcial_alva/API/usuarios/estadistica`;
    const config = { 
        method : 'GET' 
    } 
 
    try { 
        const respuesta = await fetch(url, config) 
        const data = await respuesta.json(); 
 
        chartClientes.data.labels = []; 
        chartClientes.data.datasets[0].data = []; 
        chartClientes.data.datasets[0].backgroundColor = [] 
 
 
 
        if(data){ 
 
            data.forEach( registro => { 
                chartClientes.data.labels.push(registro.rol) 
                chartClientes.data.datasets[0].data.push(registro.cantidad_usuarios) 
                chartClientes.data.datasets[0].backgroundColor.push(getRandomColor()) 
            }); 
 
        }else{ 
            Toast.fire({ 
                title : 'No se encontraron registros', 
                icon : 'info' 
            }) 
        } 
         
        chartClientes.update(); 
        
    } catch (error) { 
        console.log(error); 
    } 
} 
 
const getRandomColor = () => { 
    const r = Math.floor( Math.random() * 256) 
    const g = Math.floor( Math.random() * 256) 
    const b = Math.floor( Math.random() * 256) 
 
    const rgbColor = `rgba(${r},${g},${b},0.5)`
    return rgbColor 
} 
 
getEstadisticas(); 
 
btnActualizar.addEventListener('click', getEstadisticas )