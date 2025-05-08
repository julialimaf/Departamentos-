
<!DOCTYPE html>
<html>
<head>
  <title>Reserva de Mesas</title>
  <style>
    .radio-inputs {
      display: flex;
      justify-content: center;
      gap: 10px;
      padding: 10px;
      background-color: #EEE;
      border-radius: 8px;
      margin: 10px;
    }

    .radio-inputs .radio input {
      display: none;
    }

    .radio-inputs .radio .name {
      padding: 8px 12px;
      border-radius: 5px;
      cursor: pointer;
      background-color: #ccc;
      transition: 0.3s;
    }

    .radio-inputs .radio input:checked + .name {
      background-color: #fff;
      font-weight: bold;
    }

    * {
      box-sizing: border-box;
    }

    body {
      font-family: sans-serif;
      margin: 0;
      padding: 0;
    }

    .carrossel {
      width: 100%;
      height: 300px;
      position: relative;
      overflow: hidden;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
      margin-top: 40px;
    }

    .carrossel input[type="radio"] {
      display: none;
    }

    .slides {
      display: flex;
      width: 300%;
      height: 100%;
      transition: transform 0.5s ease;
    }

    .slide {
      width: 100%;
      height: 100%;
      flex-shrink: 0;
    }

    .slide img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    #slide1:checked ~ .slides { transform: translateX(0%); }
    #slide2:checked ~ .slides { transform: translateX(-100%); }
    #slide3:checked ~ .slides { transform: translateX(-200%); }

    .manual-nav {
      position: absolute;
      width: 100%;
      bottom: 15px;
      text-align: center;
    }

    .manual-nav label {
      cursor: pointer;
      display: inline-block;
      background: #bbb;
      width: 12px;
      height: 12px;
      margin: 0 5px;
      border-radius: 50%;
      transition: background 0.3s;
    }

    #slide1:checked ~ .manual-nav label[for="slide1"],
    #slide2:checked ~ .manual-nav label[for="slide2"],
    #slide3:checked ~ .manual-nav label[for="slide3"] {
      background: #333;
    }

    .cardapio-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    padding: 20px;
    max-width: 1200px;
    margin: 0 auto;
  }

  .item-card {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    overflow: hidden;
    text-align: center;
    transition: transform 0.3s;
  }

  .item-card:hover {
    transform: scale(1.03);
  }

  .item-card img {
    width: 100%;
    height: 180px;
    object-fit: cover;
  }

  .item-info {
    padding: 10px 15px;
  }

  .item-info h3 {
    margin: 10px 0 5px;
    font-size: 18px;
    color: #333;
  }

  .item-info p {
    font-size: 16px;
    color: #666;
  }

  .posicao{
    text-align: center;

  }
  </style>
</head>
<body>


<div class="radio-inputs">
  <label class="radio">
    <input type="radio" name="radio" checked>
    <span class="name">Cardápio</span>
  </label>
  <label class="radio">
    <input type="radio" name="radio">
    <span class="name">Reservas</span>
  </label>
  <label class="radio">
    <input type="radio" name="radio">
    <span class="name">Pedidos</span>
  </label>
</div>


<div class="carrossel">
  
  <input type="radio" name="slide" id="slide1" checked>
  <input type="radio" name="slide" id="slide2">
  <input type="radio" name="slide" id="slide3">

 
  <div class="slides">
    <div class="slide">
      <img src="https://www.ogastronomo.com.br/upload/899233299-culinaria-mexicana-7-pratos-para-levar-para-sua-mesa.jpg" alt="Slide 1">
    </div>
    <div class="slide">
      <img src="https://assets.brasildefato.com.br/2024/09/image_processing20200201-29235-1in0s85.jpg" alt="Slide 2">
    </div>
    <div class="slide">
      <img src="https://www.qgjeitinhocaseiro.com/wp-content/uploads/2019/12/comida-fácil.jpg" alt="Slide 3">
    </div>
  </div>


  <div class="manual-nav">
    <label for="slide1"></label>
    <label for="slide2"></label>
    <label for="slide3"></label>
  </div>
</div>
<h1 class="posicao">Principais escolhas da semana!</h1>
<br><br><br><br><br><br>
<div class="cardapio-grid">
  <div class="item-card">
    <img src="https://www.receiteria.com.br/wp-content/uploads/comida-mexicana-00.jpg" alt="Taco Mexicano">
    <div class="item-info">
      <h3>Taco Mexicano</h3>
      <p>R$ 18,00</p>
    </div>
  </div>





  <div class="item-card">
    <img src="https://www.qgjeitinhocaseiro.com/wp-content/uploads/2019/12/comida-fácil.jpg" alt="Feijoada">
    <div class="item-info">
      <h3>Feijoada</h3>
      <p>R$ 25,00</p>
    </div>
  </div>

  <div class="item-card">
    <img src="https://s2.glbimg.com/BnXur-kLtTSWBy1ThO-YssMlJvY=/e.glbimg.com/og/ed/f/original/2022/05/10/hamburguer-artesanal-receita.jpg" alt="Hambúrguer Artesanal">
    <div class="item-info">
      <h3>Hambúrguer</h3>
      <p>R$ 22,00</p>
    </div>
  </div>


  <div class="item-card">
    <img src="https://img.cybercook.com.br/receitas/148/salmao-grelhado-com-legumes-2.jpeg" alt="Salmão Grelhado">
    <div class="item-info">
      <h3>Salmão Grelhado</h3>
      <p>R$ 30,00</p>
    </div>
  </div>
  <div class="item-card">
    <img src="https://img.cybercook.com.br/receitas/685/pizza-margherita.jpg" alt="Pizza Margherita">
    <div class="item-info">
      <h3>Pizza Margherita</h3>
      <p>R$ 27,00</p>
    </div>
  </div>

  <div class="item-card">
    <img src="https://www.receiteria.com.br/wp-content/uploads/estrogonofe-de-frango-00.jpg" alt="Estrogonofe de Frango">
    <div class="item-info">
      <h3>Estrogonofe</h3>
      <p>R$ 20,00</p>
    </div>
  </div>
</div>
</body>
</html>