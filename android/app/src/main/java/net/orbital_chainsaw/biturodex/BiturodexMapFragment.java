package net.orbital_chainsaw.biturodex;

import android.app.Fragment;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

/**
 * Created by jivay on 24/09/14.
 */
public class BiturodexMapFragment extends Fragment {
    public BiturodexMapFragment() {
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View rootView = inflater.inflate(R.layout.fragment_biturodex_map, container, false);
        return rootView;
    }
}
