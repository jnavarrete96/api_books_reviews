# Backend — API Books & Reviews (Symfony 6)

Este backend expone una API REST construida con **Symfony 6 + Doctrine ORM** para gestionar libros y reseñas.

---

## 📌 Requisitos

* PHP >= 8.1
* Composer
* MySQL / MariaDB
* Extensiones PHP habilitadas:

  * pdo_mysql
  * intl

---

## ⚙️ Configuración del proyecto

### 1. Variables de entorno

El archivo `.env` **NO debe modificarse** para credenciales reales.

Crear un archivo **`.env.local`** con la conexión a base de datos:

```env
DATABASE_URL="mysql://usuario:password@127.0.0.1:3306/books_reviews"
```

---

### 2. Instalación de dependencias

```bash
composer install
```

---

### 3. Crear base de datos

```bash
php bin/console doctrine:database:create
```

---

### 4. Ejecutar migraciones

```bash
php bin/console doctrine:migrations:migrate
```

---

### 5. Cargar datos iniciales (fixtures)

```bash
php bin/console doctrine:fixtures:load
```

Esto cargará:

**Libros (3)**

* El Arte de Programar — Donald Knuth — 1968
* Clean Code — Robert C. Martin — 2008
* Refactoring — Martin Fowler — 1999

**Reseñas (6)**

* Al menos 2 reseñas por libro
* Ratings variados entre 1 y 5

---

### 6. Ejecutar servidor local

```bash
symfony server:start
# o
php -S localhost:8000 -t public
```

---

## 🔌 Endpoints disponibles

### GET `/api/books`

Devuelve la lista de libros con su rating promedio.

Ejemplo de respuesta:

```json
[
  {
    "title": "Clean Code",
    "author": "Robert C. Martin",
    "published_year": 2008,
    "average_rating": 4.5
  }
]
```

---

### POST `/api/reviews`

Registra una nueva reseña.

**Request body**:

```json
{
  "book_id": 1,
  "rating": 5,
  "comment": "Excelente libro"
}
```

**Validaciones**:

* `rating`: entero entre 1 y 5
* `book_id`: debe existir
* `comment`: no vacío

Errores devueltos con status **400** y mensajes claros en JSON.

---

## 🧠 Decisiones técnicas

### 📊 Cálculo de `average_rating`

El promedio de calificación se calcula **directamente en base de datos** usando una consulta Doctrine con `AVG()`:

```sql
AVG(r.rating)
```

Además, se utiliza:

```sql
ROUND(AVG(r.rating), 2)
```

Esto se habilitó configurando la función `ROUND` en Doctrine DQL mediante `doctrine-extensions`.

**Motivo**:

* Evitar cálculos en PHP
* Prevenir problemas de rendimiento (N+1 queries)
* Delegar el cálculo al motor de base de datos

---

### ❓ ¿Por qué `average_rating` puede ser `null`?

Cuando un libro **no tiene reseñas**, la función `AVG()` devuelve `NULL`.

Se decidió **mantener `null`** en lugar de forzar `0` para:

* Diferenciar claramente entre:

  * *"no hay reseñas"* (`null`)
  * *"reseñas con rating bajo"* (ej. `1.0`)
* Mantener consistencia con el comportamiento estándar de SQL

Esta decisión se documenta explícitamente según lo solicitado en la prueba técnica.

---

## 🌐 CORS

Se configuró **NelmioCorsBundle** para permitir el consumo de la API desde:

* Frontend Vue 3
* Frontend React Native

Durante la prueba se permite:

```yaml
allow_origin: ['*']
```

---

## 🧪 Testing

No se incluyeron tests automatizados en esta entrega.

---

## ✅ Estado

El backend queda listo para ser consumido por:

* Vue 3 (web)
* React Native (mobile)

Cumple con los requerimientos técnicos solicitados en la prueba.
