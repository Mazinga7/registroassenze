document.getElementById('assenzeForm').addEventListener('submit', function(event) {
    event.preventDefault();
    const nome = document.getElementById('nome').value;
    const cognome = document.getElementById('cognome').value;
    const data = document.getElementById('data').value;
    const motivo = document.getElementById('motivo').value;
    const squadriglia = document.getElementById('Squadriglia').value;
    const assenzeSq = document.getElementById('sq').checked ? 1 : 0;
    const assenzeReparto = document.getElementById('reparto').checked ? 1 : 0;

    fetch('/addAbsence', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ nome, cognome, data, motivo, squadriglia, assenzeSq, assenzeReparto })
    }).then(response => response.json())
      .then(data => {
          loadData();
          document.getElementById('assenzeForm').reset();
      });
});

document.getElementById('searchBar').addEventListener('keyup', function() {
    const filter = this.value.toLowerCase();
    const rows = document.getElementById('assenzeTable').getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    let totalAssenzeSq = 0;
    let totalAssenzeReparto = 0;

    for (let i = 0; i < rows.length; i++) {
        const nome = rows[i].getElementsByTagName('td')[0].textContent.toLowerCase();
        const cognome = rows[i].getElementsByTagName('td')[1].textContent.toLowerCase();
        if (nome.includes(filter) || cognome.includes(filter)) {
            rows[i].style.display = '';
            totalAssenzeSq += parseInt(rows[i].getElementsByTagName('td')[5].textContent);
            totalAssenzeReparto += parseInt(rows[i].getElementsByTagName('td')[6].textContent);
        } else {
            rows[i].style.display = 'none';
        }
    }

    document.getElementById('totalAssenzeSq').textContent = totalAssenzeSq;
    document.getElementById('totalAssenzeReparto').textContent = totalAssenzeReparto;
});

function loadData() {
    fetch('/getAbsences')
        .then(response => response.json())
        .then(data => {
            const table = document.getElementById('assenzeTable').getElementsByTagName('tbody')[0];
            table.innerHTML = ''; // Clear existing rows

            data.forEach(row => {
                const newRow = table.insertRow();
                newRow.insertCell(0).textContent = row.nome;
                newRow.insertCell(1).textContent = row.cognome;
                newRow.insertCell(2).textContent = row.data;
                newRow.insertCell(3).textContent = row.motivo;
                newRow.insertCell(4).textContent = row.squadriglia;
                newRow.insertCell(5).textContent = row.assenzeSq;
                newRow.insertCell(6).textContent = row.assenzeReparto;
                const actionsCell = newRow.insertCell(7);
                const deleteButton = document.createElement('button');
                deleteButton.textContent = 'Elimina';
                deleteButton.addEventListener('click', function() {
                    fetch(`/deleteAbsence/${row.id}`, { method: 'DELETE' })
                        .then(response => response.json())
                        .then(data => {
                            loadData();
                        });
                });
                actionsCell.appendChild(deleteButton);
            });
        });
}

window.onload = loadData;