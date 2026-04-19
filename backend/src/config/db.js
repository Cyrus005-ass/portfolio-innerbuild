const { Pool } = require('pg');

const pool = new Pool({
  host: process.env.DB_HOST,
  port: Number(process.env.DB_PORT || 5432),
  user: process.env.DB_USER,
  password: process.env.DB_PASS,
  database: process.env.DB_NAME,
  max: 10,
  idleTimeoutMillis: 30000,
  connectionTimeoutMillis: 10000,
  ssl: process.env.DB_SSL === 'true' ? { rejectUnauthorized: false } : undefined
});

function toPgQuery(sql, params = []) {
  let index = 0;
  const text = sql.replace(/\?/g, () => `$${++index}`);
  return { text, values: params };
}

async function execute(sql, params = []) {
  const { text, values } = toPgQuery(sql, params);
  const isInsert = /^\s*INSERT\b/i.test(sql);
  const isSelect = /^\s*SELECT\b/i.test(sql);

  if (isInsert && !/\bRETURNING\b/i.test(text)) {
    const result = await pool.query(`${text} RETURNING id`, values);
    return [{ insertId: result.rows[0]?.id ?? null, rowCount: result.rowCount }, result.fields];
  }

  const result = await pool.query(text, values);

  if (isSelect) {
    return [result.rows, result.fields];
  }

  return [{ affectedRows: result.rowCount, rowCount: result.rowCount }, result.fields];
}

module.exports = {
  execute,
  query: execute,
  pool
};
