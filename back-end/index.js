const express = require('express')
const app = express()
const port = 65535

// Import the router
const router = require('./router');

// Use the router for a specific path
app.use('/api', router);

app.get('/', (req, res) => {
    res.send('Hello World!')
})

app.listen(port, () => {
    console.log(`Example app listening on port ${port}`)
})