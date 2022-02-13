<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RepairController;


/*
|------------------------------------------------------------------------------------------------------------------------------------
| Middlewares
|------------------------------------------------------------------------------------------------------------------------------------

adminMiddleware => Controla las rutas a las que solo tiene accesso el administrador
administrativeMiddleware => Controla las rutas a las que solo tienen acceso el administrador y el administrativo
administrativeClientMiddleware => Controla las rutas a las que solo tienen acceso el administrador , administrativo o el cliente
administrativeMechanicMiddleware => Controla las rutas a las que solo tienen acceso el administrador , administrativo o el mecánico
mechanicMiddleware => Controla las rutas a las que solo tiene accesso el mecánico
clientMiddleware => Controla las rutas a las que solo tiene accesso el cliente

|------------------------------------------------------------------------------------------------------------------------------------
| Multilingual (LanguageController)
|------------------------------------------------------------------------------------------------------------------------------------
*/

// Función para cambiar de idioma
if (file_exists(app_path('Http/Controllers/LanguageController.php'))) {
    Route::get('lang/{locale}', [LanguageController::class, 'swap'])->name('swap');
}

/*
|--------------------------------------------------------------------------
| MainController
|--------------------------------------------------------------------------
*/

// Función que devuelve la página principal de la tienda
Route::get('/index', [MainController::class, 'index'])->name('index');

/*
|------------------------------------------------------------------------------------------------------------------------------------
| LoginController - Funciones de inicio de sesión y registro
|------------------------------------------------------------------------------------------------------------------------------------
*/

// Vista de registro
Route::get('/register', [LoginController::class, 'register'])->name('register');
// Validación de registro del usuario
Route::post('/checkRegister', [LoginController::class, 'checkRegister'])->name('checkRegister');

// Vista de inicio de sesión
Route::get('/login', [LoginController::class, 'login'])->name('login');
// Validación de inicio de sesión
Route::post('/login/checkLogin', [LoginController::class, 'checkLogin'])->name('checkLogin');

// Validación para comprobar si el email pertenece al usuario que se ha registrado
Route::get('/register/verify/{code}', [LoginController::class, 'verifyEmail'])->name('verifyAccount');

// Vista para introducir correo para recuperar contraseña
Route::get('/forgottenPassword', [LoginController::class, 'forgottenPassword'])->name('forgottenPassword');

// Validación de si el email está registrado para mandar un enlace para cambiar la contraseña
Route::post('/recoverPassword', [LoginController::class, 'recoverPassword'])->name('recoverPassword');

// Comprobación de si el código de la base de datos coincide con el del email
Route::get('/changePassword/{code}', [LoginController::class, 'validateChangePassword'])->name('validateChangePassword');
// Vista para cambiar la contraseña
Route::post('/changePassword', [LoginController::class, 'changePassword'])->name('changePassword');

// Función para cerrar la sesión de usuario
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');


Route::prefix('/account')->group(function () {

    // Función para ver tus datos de usuario
    Route::get('/myAccount', [UserController::class, 'index'])->name('myAccount');

    // Función para actualizar tu propia cuenta
    Route::post('/updateAccount', [UserController::class, 'updateAccount'])->name('updateAccount');
});


/*
|------------------------------------------------------------------------------------------------------------------------------------
| UserController - Funciones para trabajar con clientes y trabajadores (añadir, editar ...)
|------------------------------------------------------------------------------------------------------------------------------------
*/

Route::group(['middleware' => 'administrativeMiddleware'], function () {

    Route::prefix('/clients')->group(function () {

        // Función que devuelve la vista para ver todos los clientes
        Route::get('/listClients', [UserController::class, 'listClients'])->name('listClients');

        // Función que devuelve la vista para ver un cliente concreto
        Route::get('/viewClient/{id}', [UserController::class, 'viewClient'])->name('viewClient');

        // Función para actualizar un cliente o trabajdor, dependiendo desde dónde se haya llamado
        Route::post('/updateClient', [UserController::class, 'updateClient'])->name('updateClient');
    });

    Route::prefix('/workers')->group(function () {

        // Función para guardar un nuevo trabajador
        Route::post('/storeWorker', [UserController::class, 'storeWorker'])->name('storeWorker');

        // Función que devuelve la vista para ver todos los trabajadores
        Route::get('/listWorkers', [UserController::class, 'listWorkers'])->name('listWorkers');

        // Función que devuelve la vista para ver un cliente concreto
        Route::get('/viewWorker/{id}', [UserController::class, 'viewWorker'])->name('viewWorker');
    });

    // Función para habilitar a un usuario
    Route::get('/disableUser', [UserController::class, 'disableUser'])->name('disableUser');

    // Función para deshabilitar a un usuario
    Route::get('/ableUser', [UserController::class, 'ableUser'])->name('ableUser');

});


Route::group(['middleware' => 'adminMiddleware'], function () {
    // Función que devuelve la vista para añadir un nuevo trabajador
    Route::get('/addWorker', [UserController::class, 'addWorker'])->name('addWorker');
});


/*
|------------------------------------------------------------------------------------------------------------------------------------
| CarController - Funciones para trabajar con coches (añadir, editar ...)
|------------------------------------------------------------------------------------------------------------------------------------
*/

Route::prefix('/cars')->group(function () {

    Route::group(['middleware' => 'administrativeMiddleware'], function () {

        // Función que devuelve la vista para añadir un nuevo coche a un cliente
        Route::get('/addCar/{id}', [CarController::class, 'addCar'])->name('addCar');

        // Función para añadir el coche al cliente
        Route::post('/storeCar', [CarController::class, 'storeCar'])->name('storeCar');

        // Función que devuelve la vista para ver todos los coches
        Route::get('/listCars', [CarController::class, 'listCars'])->name('listCars');

        // Función para actualizar el coche
        Route::post('/updateCar', [CarController::class, 'updateCar'])->name('updateCar');

    });

    Route::group(['middleware' => 'clientMiddleware'], function () {

        // Función que devuelve la vista para ver un coche concreto desde un usuario cliente
        Route::get('/myCars', [CarController::class, 'myCars'])->name('myCars');

    });

    Route::group(['middleware' => 'administrativeClientMiddleware'], function () {

        // Función que devuelve la vista para ver un coche concreto
        Route::get('/viewCar/{id}', [CarController::class, 'viewCar'])->name('viewCar');

    });

    // Función que carga el select de marcas de coches
    Route::get('/getBrands', [CarController::class, 'getBrands'])->name('getBrands');

    // Función que carga el select de modelos de coches
    Route::get('/getModels', [CarController::class, 'getModels'])->name('getModels');

    // Función que carga el select de motores de coches
    Route::get('/getEngines', [CarController::class, 'getEngines'])->name('getEngines');

});

/*
|------------------------------------------------------------------------------------------------------------------------------------
| AppointmentController - Funciones para trabajar con citas (añadir, editar ...)
|------------------------------------------------------------------------------------------------------------------------------------
*/

Route::prefix('/appointments')->group(function () {

    Route::group(['middleware' => 'administrativeMiddleware'], function () {

        // Función que devuelve la vista para ver todas las citas con fecha igual o superior a la actual
        Route::get('/listAppointments', [AppointmentController::class, 'listAppointments'])->name('listAppointments');

        // Función para confirmar una cita
        Route::get('/confirmAppointment', [AppointmentController::class, 'confirmAppointment'])->name('confirmAppointment');

    });

    Route::group(['middleware' => 'clientMiddleware'], function () {

        // Función que devuelve la vista para añadir una nueva cita
        Route::get('/makeAppointment', [AppointmentController::class, 'makeAppointment'])->name('makeAppointment');

        // Función para rellenar el select con las horas disponibles
        Route::get('/fillHours', [AppointmentController::class, 'getAvailableAppointments'])->name('fillHours');

        //Función para guardar una nueva cita
        Route::post('/storeAppointment', [AppointmentController::class, 'storeAppointment'])->name('storeAppointment');

        // Función que devuelve la vista para ver tus citas
        Route::get('/listClientAppointments', [AppointmentController::class, 'listClientAppointments'])->name('listClientAppointments');

    });

    Route::group(['middleware' => 'administrativeClientMiddleware'], function () {

        // Función para cancelar una cita
        Route::get('/cancelAppointment', [AppointmentController::class, 'cancelAppointment'])->name('cancelAppointment');

    });

});


/*
|------------------------------------------------------------------------------------------------------------------------------------
| ShopController - Funciones de la tienda
|------------------------------------------------------------------------------------------------------------------------------------
*/

Route::prefix('/shop')->group(function () {

    Route::group(['middleware' => 'administrativeMiddleware'], function () {

        // Función que devuelve la vista para añadir un nuevo artículo
        Route::get('/newArticle', [ShopController::class, 'newArticle'])->name('newArticle');

        // Función para guardar un nuevo artículo
        Route::post('/storeArticle', [ShopController::class, 'storeArticle'])->name('storeArticle');

        // Función para ver todos los pedidos que se han hecho en la tienda
        Route::get('/listOrders', [ShopController::class, 'listOrders'])->name('listOrders');

        // Función que devuelve la vista para editar un artículo
        Route::get('/editArticle/{id}', [ShopController::class, 'editArticle'])->name('editArticle');

        // Función para actualizar el artículo
        Route::post('/updateArticle', [ShopController::class, 'updateArticle'])->name('updateArticle');

    });

    Route::group(['middleware' => 'clientMiddleware'], function () {

        // Función para ver las citas de un cliente
        Route::get('/myOrders', [ShopController::class, 'myOrders'])->name('myOrders');

    });

    Route::group(['middleware' => 'administrativeClientMiddleware'], function () {

        // Función para ver artículos de la tienda
        Route::get('/articles/{category}', [ShopController::class, 'shop'])->name('shop');

        // Función para buscar por nombre en la tienda
        Route::get('/searchShop', [ShopController::class, 'searchShop'])->name('searchShop');

        // Función para buscar por tipo de motor en la tienda
        Route::get('/searchShopEngine', [ShopController::class, 'searchShopEngine'])->name('searchShopEngine');

        // Función para ver los detalles de un artículo
        Route::get('/articleDetails/{id}', [ShopController::class, 'articleDetails'])->name('articleDetails');

        // Función que devuelve la vista para ver un pedido concreto
        Route::get('/viewOrder/{id}', [ShopController::class, 'viewOrder'])->name('viewOrder');

        // Función para sacar el pdf de un pedido
        Route::get('/printOrder/{id}', [ShopController::class, 'printOrder'])->name('printOrder');

    });

});

/*
|------------------------------------------------------------------------------------------------------------------------------------
| CartController - Funciones para trabajar con el carrito de la tienda
|------------------------------------------------------------------------------------------------------------------------------------
*/

Route::prefix('/cart')->group(function () {

    Route::group(['middleware' => 'clientMiddleware'], function () {

        // Función que devuelve el carrito
        Route::get('/cartIndex', [CartController::class, 'cartIndex'])->name('cartIndex');

        // Función para añadir un artículo al carrito de la compra
        Route::post('/cartAdd', [CartController::class, 'cartAdd'])->name('cartAdd');

        // Función para añadir una cantidad de un artículo al carrito de la compra
        Route::post('/cartAddAmount', [CartController::class, 'cartAddAmount'])->name('cartAddAmount');

        // Función para eliminar un artículo del carrito de la compra
        Route::get('/cartRemoveItem', [CartController::class, 'cartRemoveItem'])->name('cartRemoveItem');

        // Función para actualizar la cantidad de un artículo del carrito de la compra
        Route::get('/updateCartArticle', [CartController::class, 'updateCartArticle'])->name('updateCartArticle');

        // Función para procesar el pedido
        Route::get('/cartCheckout', [CartController::class, 'cartCheckout'])->name('cartCheckout');

        // Función para vaciar el carrito
        Route::get('/cartClear', [CartController::class, 'cartClear'])->name('cartClear');

    });

});

/*
|------------------------------------------------------------------------------------------------------------------------------------
| PaymentController - Funciones para pagar con paypal
|------------------------------------------------------------------------------------------------------------------------------------
*/

Route::group(['middleware' => 'clientMiddleware'], function () {

    // Funciones para pagar un pedido de la tienda

    Route::post('/payPal/payOrder', [PaymentController::class, 'payOrderWithPayPal'])->name('payOrderWithPayPal');

    Route::get('/payPal/orderStatus', [PaymentController::class, 'payPalStatusOrder'])->name('payPalStatusOrder');

    // Funciones para pagar una reparación

    Route::get('/payPal/payRepair{id}', [PaymentController::class, 'payRepairWithPayPal'])->name('payRepairWithPayPal');

    Route::get('/payPal/repairStatus/{id}', [PaymentController::class, 'payPalStatusRepair'])->name('payPalStatusRepair');

});


/*
|------------------------------------------------------------------------------------------------------------------------------------
| RepairController - Funciones para trabajar con las reparaciones
|------------------------------------------------------------------------------------------------------------------------------------
*/

Route::prefix('/repairs')->group(function () {

    Route::group(['middleware' => 'administrativeMiddleware'], function () {

        // Función para marcar una reparación como pagada si el cliente paga en el taller
        Route::get('/payRepair', [RepairController::class, 'payRepair'])->name('payRepair');

    });

    Route::group(['middleware' => 'mechanicMiddleware'], function () {

        // Función que devuelve la vista para ver una reparación concreta
        Route::get('/viewRepair/{id}', [RepairController::class, 'viewRepair'])->name('viewRepair');

        // Función para actualizar la reparación
        Route::post('/updateRepair', [RepairController::class, 'updateRepair'])->name('updateRepair');

        // Función para añadir un trabajo a la reparación
        Route::get('/addWork', [RepairController::class, 'addWork'])->name('addWork');

        // Función para obtener la información de un trabajo
        Route::get('/getWorkData', [RepairController::class, 'getWorkData'])->name('getWorkData');

        // Función para actualizar un trabajo
        Route::get('/updateWork', [RepairController::class, 'updateWork'])->name('updateWork');

        // Función para borrar un trabajo
        Route::get('/deleteWork', [RepairController::class, 'deleteWork'])->name('deleteWork');

        // Función para seleccionar los articulos de un coche concreto
        Route::get('/getReplacements', [RepairController::class, 'getReplacements'])->name('getReplacements');

        // Función para saber si hay suficiente stock de un repuesto
        Route::get('/checkStock', [RepairController::class, 'checkStock'])->name('checkStock');

        // Función para comprobar si se han añadido trabajos para poder completar la reparación
        Route::get('/checkWorks', [RepairController::class, 'checkWorks'])->name('checkWorks');

        // Función para saber si hay suficiente stock de un repuesto
        Route::get('/checkArticleInRepair', [RepairController::class, 'checkArticleInRepair'])->name('checkArticleInRepair');

        // Función para añadir un repuesto a la reparación
        Route::get('/addReplacement', [RepairController::class, 'addReplacement'])->name('addReplacement');

        // Función para obtener la información de un repuesto
        Route::get('/getReplacementData', [RepairController::class, 'getReplacementData'])->name('getReplacementData');

        // Función para actualizar un repuesto
        Route::get('/updateReplacement', [RepairController::class, 'updateReplacement'])->name('updateReplacement');

        // Función para borrar un repuesto
        Route::get('/deleteReplacement', [RepairController::class, 'deleteReplacement'])->name('deleteReplacement');

        // Función para completar una reparación
        Route::get('/completeRepair', [RepairController::class, 'completeRepair'])->name('completeRepair');

    });

    Route::group(['middleware' => 'administrativeClientMiddleware'], function () {

        // Función para sacar el pdf de una reparación
        Route::get('/printRepair/{id}', [RepairController::class, 'printRepair'])->name('printRepair');

        // Función para comprobar si se puede cancelar una reparación
        Route::get('/checkDeleteRepair', [RepairController::class, 'checkDeleteRepair'])->name('checkDeleteRepair');

        // Función para cancelar una reparación
        Route::get('/cancelRepair', [RepairController::class, 'cancelRepair'])->name('cancelRepair');

        // Función que devuelve la vista a un cliente para ver una reparación concreta
        Route::get('/viewClientRepair/{id}', [RepairController::class, 'viewClientRepair'])->name('viewClientRepair');

    });

    Route::group(['middleware' => 'administrativeMechanicMiddleware'], function () {

        // Función que devuelve la vista para ver todas las reparaciones
        Route::get('/listRepairs', [RepairController::class, 'listRepairs'])->name('listRepairs');

    });

    Route::group(['middleware' => 'clientMiddleware'], function () {

        // Función que devuelve la vista para ver tus reparaciones
        Route::get('/listClientRepairs', [RepairController::class, 'listClientRepairs'])->name('listClientRepairs');

    });

});
