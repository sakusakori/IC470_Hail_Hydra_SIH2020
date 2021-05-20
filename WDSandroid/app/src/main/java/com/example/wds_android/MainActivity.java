package com.example.wds_android;

import androidx.appcompat.app.AppCompatActivity;

import android.annotation.SuppressLint;
import android.os.Bundle;
import android.view.Window;
import android.view.WindowManager;
import android.webkit.WebView;
import android.webkit.WebViewClient;

public class MainActivity extends AppCompatActivity {
    private WebView wds_webView;
    @SuppressLint("SetJavaScriptEnabled")
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        requestWindowFeature(Window.FEATURE_NO_TITLE); // Hide the title
        getSupportActionBar().hide(); // Hide the title bar
//        this.getWindow().setFlags(WindowManager.LayoutParams.FLAG_FULLSCREEN, WindowManager.LayoutParams.FLAG_FULLSCREEN); // Show the activity in full screen
        setContentView(R.layout.activity_main);
        wds_webView = (WebView) findViewById(R.id.webView);
        wds_webView.setWebViewClient(new WebViewClient());
        wds_webView.getSettings().setJavaScriptEnabled(true);
        wds_webView.loadUrl("http://water.coolpage.biz");
    }

    @Override
    public void onBackPressed() {
        if(wds_webView.canGoBack()) {
            wds_webView.goBack();
        }
        else {
            super.onBackPressed();
        }
    }
}
