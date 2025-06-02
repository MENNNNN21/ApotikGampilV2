<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-box {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }
        .login-box h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
        }
        button:hover {
            background-color: #218838;
        }
        .register-link {
            margin-top: 10px;
            text-align: center;
        }
        .register-link a {
            color: #007bff;
            text-decoration: none;
        }
        .register-link a:hover {
            text-decoration: underline;
        }
        .alert-danger {
            background-color: #f8d7da; /* Warna latar belakang merah muda */
            color: #721c24; /* Warna teks merah tua */
            padding: 10px 15px; /* Padding di dalam kotak */
            margin-bottom: 20px; /* Jarak bawah agar terpisah dari form */
            border: 1px solid #f5c6cb; /* Border tipis warna merah */
            border-radius: 4px; /* Sudut melengkung, samakan dengan input */
            text-align: center; /* Teks di tengah (opsional) */
        }
    </style>
</head>
<body>

    

    <div class="login-box">
        <h2>Login Apotik</h2>
        @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
       <form action="{{ url('/login') }}" method="POST"> 
        @csrf <div class="form-group"> 
        <label for="email">Email</label> 
        <input type="email" name="email" id="email" required> 
    </div> 
        <div class="form-group"> <label for="password">Password</label> 
        <input type="password" name="password" id="password" required autocomplete="off"> 
    </div> 
        <button type="submit">Login</button> 
        <div class="register-link">
            <p>Belum Punya Akun? <a href="{{url('/register')}}">Daftar</a></p>
        </div>
    </form>
    
    
</div>

    

   
   
</body>
</html>