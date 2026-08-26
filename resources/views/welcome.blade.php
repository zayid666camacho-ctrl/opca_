<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Welcome</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gray-100">


<div class="max-w-md w-full mx-auto p-8">

        <h1 class="text-3xl font-bold text-center text-gray-800 mb-8">
            WELCOME
        </h1>

        <div class="flex flex-col gap-4">

            <a href="{{ route('clientes.index') }}"
            class="bg-white border border-gray-200 rounded-lg shadow px-6 py-4 text-center font-semibold text-gray-700 hover:bg-blue-600 hover:text-white transition">
                Clientes
            </a>


        </div>

</body>
</html>