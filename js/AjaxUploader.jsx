import React, { useRef, useEffect } from 'react';
import $ from 'jquery';
import './is.ajaxupload.js';
import '../is.ajaxupload.css';

/**
 * React component that wraps the jQuery ajaxUpload plugin.
 */
function AjaxUploader({
  action,
  params = {},
  defaultUploadMethod = 'xhr',
  onComplete = () => {},
}) {
  const containerRef = useRef(null);

  useEffect(() => {
    const $el = $(containerRef.current);
    $el.ajaxUpload({
      action,
      params,
      defaultUploadMethod,
      onComplete,
    });
    return () => {
      // cleanup on unmount
      $el.off();
      $el.empty();
    };
  }, [action, params, defaultUploadMethod, onComplete]);

  return (
    <div ref={containerRef}>
      <noscript>You should enable JavaScript to use this uploader!</noscript>
    </div>
  );
}

export default AjaxUploader;
