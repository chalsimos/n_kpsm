import { openDB } from 'idb';

const DB_NAME = 'TupadDB';
const STORE_NAME = 'requests';

const initDB = async () => {
  const db = await openDB(DB_NAME, 1, {
    upgrade(db) {
      if (!db.objectStoreNames.contains(STORE_NAME)) {
        db.createObjectStore(STORE_NAME, { keyPath: 'id', autoIncrement: true });
      }
    },
  });
  return db;
};

export const saveTupadRequest = async (request) => {
  const db = await initDB();
  await db.put(STORE_NAME, request);
};

export const getTupadRequests = async () => {
  const db = await initDB();
  return await db.getAll(STORE_NAME);
};

export const clearTupadRequests = async () => {
  const db = await initDB();
  await db.clear(STORE_NAME);
};
