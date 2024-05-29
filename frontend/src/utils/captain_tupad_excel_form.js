import { openDB } from 'idb';

const DB_NAME = 'CaptainTupadExcelForm';
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
export const saveRequest = async (request) => {
  const db = await initDB();
  const tx = db.transaction(STORE_NAME, 'readwrite');
  const store = tx.objectStore(STORE_NAME);
  const excelBlob = new Blob([request.excelFile], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
  const imageBlobs = request.imageFiles.map(imageFile => new Blob([imageFile], { type: imageFile.type }));
  const excelFileKey = await store.put(excelBlob);
  const imageFileKeys = await Promise.all(imageBlobs.map(blob => store.put(blob)));
  const requestEntry = {
      excelFileKey,
      imageFileKeys,
      tupadSlotId: request.tupadSlotId
  };
  await store.add(requestEntry);
  await tx.done;
};

export const getRequests = async () => {
  const db = await initDB();
  const tx = db.transaction(STORE_NAME, 'readonly');
  const store = tx.objectStore(STORE_NAME);
  const requests = await store.getAll();
  const requestsWithData = await Promise.all(requests.map(async request => {
      const excelBlob = await store.get(request.excelFileKey);
      const imageBlobs = await Promise.all(request.imageFileKeys.map(key => store.get(key)));
      const excelFile = new File([await excelBlob.arrayBuffer()], 'excel_file.xlsx', { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
      const imageFiles = imageBlobs.map(blob => new File([blob], `image_${imageBlobs.indexOf(blob)}.png`, { type: blob.type }));
      return {
          excelFile,
          imageFiles,
          tupadSlotId: request.tupadSlotId
      };
  }));
  await tx.done;
  return requestsWithData;
};

export const clearRequests = async () => {
  const db = await initDB();
  const tx = db.transaction(STORE_NAME, 'readwrite');
  const store = tx.objectStore(STORE_NAME);
  await store.clear();
  await tx.done;
};

