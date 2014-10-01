package net.orbital_chainsaw.biturodex;

import android.app.Dialog;
import android.app.DialogFragment;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

/**
 * Created by jivay on 29/09/14.
 */
public class SearchFilterDialogFragment extends DialogFragment{

    public SearchFilterDialogFragment(){

    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstState){
        getDialog().setTitle("Filtres de recherche");
        return inflater.inflate(R.layout.fragment_search_filter_dialog, container);
    }
}
