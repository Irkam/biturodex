package net.orbital_chainsaw.biturodex;

import android.app.Activity;

import android.app.ActionBar;
import android.app.FragmentManager;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.support.v4.widget.DrawerLayout;

public class MainActivity extends Activity
        implements NavigationDrawerFragment.NavigationDrawerCallbacks {
    private final int DRAWER_SEARCH_MAP = 0;
    private final int DRAWER_SEARCH_LIST = 1;
    private final int DRAWER_MY_EVENTS = 2;
    private final int DRAWER_MY_ESTABLISHMENTS = 3;
    private final int DRAWER_SETTINGS = 4;
    private final int DRAWER_ABOUT = 5;

    /**
     * Fragment managing the behaviors, interactions and presentation of the navigation drawer.
     */
    private NavigationDrawerFragment mNavigationDrawerFragment;

    /**
     * Used to store the last screen title. For use in {@link #restoreActionBar()}.
     */
    private CharSequence mTitle;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        mNavigationDrawerFragment = (NavigationDrawerFragment)
                getFragmentManager().findFragmentById(R.id.navigation_drawer);
        mTitle = getTitle();

        // Set up the drawer.
        mNavigationDrawerFragment.setUp(
                R.id.navigation_drawer,
                (DrawerLayout) findViewById(R.id.drawer_layout));

        getFragmentManager().beginTransaction()
                .replace(R.id.container, new SearchMapFragment())
                .commit();
    }

    @Override
    public void onNavigationDrawerItemSelected(int position) {
        FragmentManager fragmentManager = getFragmentManager();
        switch(position){
            case DRAWER_SEARCH_MAP:
                fragmentManager.beginTransaction()
                        .replace(R.id.container, new SearchMapFragment())
                        .commit();
                break;
            case DRAWER_SEARCH_LIST:
                fragmentManager.beginTransaction()
                        .replace(R.id.container, new EventsListFragment())
                        .commit();
                break;
            case DRAWER_MY_EVENTS:
                fragmentManager.beginTransaction()
                        .replace(R.id.container, new MyEventsFragment())
                        .commit();
                break;
            case DRAWER_MY_ESTABLISHMENTS:
                fragmentManager.beginTransaction()
                        .replace(R.id.container, new MyEstablishmentsFragment())
                        .commit();
                break;
            case DRAWER_SETTINGS:
                fragmentManager.beginTransaction()
                        .replace(R.id.container, new EventsListFragment())
                        .commit();
                break;
            case DRAWER_ABOUT:
                fragmentManager.beginTransaction()
                        .replace(R.id.container, new AboutFragment())
                        .commit();
                break;
        }
    }

    public void onSectionAttached(int number) {
        switch (number) {
            case 1:
                mTitle = getString(R.string.title_menu_realtime);
                break;
            case 2:
                mTitle = getString(R.string.title_menu_list);
                break;
            case 3:
                mTitle = getString(R.string.title_menu_my_events);
                break;
            case 4:
                mTitle = getString(R.string.title_menu_my_establishments);
                break;
            case 5:
                mTitle = getString(R.string.title_menu_settings);
                break;
            case 6:
                mTitle = getString(R.string.title_menu_about);
                break;
        }
    }

    public void restoreActionBar() {
        ActionBar actionBar = getActionBar();
        actionBar.setNavigationMode(ActionBar.NAVIGATION_MODE_STANDARD);
        actionBar.setDisplayShowTitleEnabled(true);
        actionBar.setTitle(mTitle);
    }


    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        if (!mNavigationDrawerFragment.isDrawerOpen()) {
            // Only show items in the action bar relevant to this screen
            // if the drawer is not showing. Otherwise, let the drawer
            // decide what to show in the action bar.
            getMenuInflater().inflate(R.menu.main, menu);
            restoreActionBar();
            return true;
        }
        return super.onCreateOptionsMenu(menu);
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();
        if (id == R.id.action_settings) {
            return true;
        }
        return super.onOptionsItemSelected(item);
    }

}
