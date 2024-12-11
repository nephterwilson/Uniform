// order.js
document.getElementById('orderButton').addEventListener('click', function() {
    fetch('/initiate-payment', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        amount: 100,
        order_id: '12345'
      })
    })
    .then(response => response.json())
    .then(data => {
      window.location.href = data.payment_url;
    })
    .catch(error => console.error('Error:', error));
  });
  