# PHP Simple API

I created an API in PHP without any framework, connecting a MariaDB database using PDO, and already configured it with Docker and Composer. Also, when the docker starts creating the database and the tables used in this API to make the setup easy.

# Running

You can run the API using the following command:

```bash
docker compose up --build -d
```

The API will be available in `http://localhost:9000/`.

If you want to update the code and this reflects in the API without building everything again you can run this command later:

```bash
docker compose watch
```

When you would like to remove everything can run this one:

```bash
docker compose down --volumes
```

## APIs

There are two main endpoints created to test the concepts of this API topics and movies.

- `/api/topics` : Can create/update/delete and list all topics.
- `/api/movies`: Can create/update/delete and list all movies.

There is a Postman collection in the root folder with the name `PHP - Simple API.postman_collection.json` that has all the endpoints available.
