import React from 'react';
import { FileInput, FileField } from 'react-admin';

const FileUploadInput = (props) => (
  <FileInput {...props}>
    <FileField source="src" title="title" />
  </FileInput>
);

export default FileUploadInput;
